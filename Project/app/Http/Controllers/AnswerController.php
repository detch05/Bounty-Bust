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
            'title' => 'required|string|min:5|max:50',
            'description' => 'required|string',
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

        

        return redirect()->route('bounties.show', ['bounty' => $validatedData['bounty_id']]);
    }
}
