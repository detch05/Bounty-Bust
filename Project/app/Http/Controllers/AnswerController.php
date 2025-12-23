<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|min:5|max:50',
            'description' => 'required|min:15|string',
            'bounty_id' => 'required|integer|exists:bounty,id_content',
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $bountyId = $request->input('bounty_id');

        $content = Content::create([
            'description' => $description,
            'user_id' => Auth::id(),
        ]);

        $answer = Answer::create([
            'id_content' => $content->id,
            'title' => $title,
            'bounty_id' => $bountyId,
        ]);

        if($request->hasFile('answerImage')){
            $answer->handleAnswerIMG($request->file('answerImage'));
        }

        return redirect()->route('bounties.show', $bountyId)->with('success', 'Answer submitted successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|min:5|max:50',
            'description' => 'required|min:15|string',
        ]);

        $answer = Answer::with('content')->findOrFail($id);

        $answer->title = $request->input('title');
        $answer->content->description = $request->input('description');
        $answer->content->updated_at = now();
        $answer->content->save();

        if($request->hasFile('answerImage')){
            $answer->handleAnswerIMG($request->file('answerImage'));
        }

        return redirect()->route('bounties.show', $answer->bounty_id)->with('success', 'Answer updated successfully!');
    }

    public function create($bountyId)
    {
        return view('pages.content.answer.create_answer', ['bounty_id' => $bountyId]);
    }

    public function editBounty($id){
        $answer= Answer::with('content')->findOrFail($id);
        return view('pages.content.answer.edit_answer', compact('answer'));
    }

    public function delete($id)
    {
        $answer = Answer::with('content')->findOrFail($id);
        $bountyId = $answer->bounty_id;

        $answer->content->delete();
        $answer->delete();

        return redirect()->route('bounties.show', $bountyId)->with('success', 'Answer deleted successfully!');
    }
}
