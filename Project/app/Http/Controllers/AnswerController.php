<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Bounty;
use App\Models\Comment;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        if ($request->hasFile('answerImage')) {
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
        $this->authorize('update', $answer);

        $answer->title = $request->input('title');
        $answer->content->description = $request->input('description');
        $answer->content->updated_at = now();
        $answer->content->save();

        if ($request->hasFile('answerImage')) {
            $answer->handleAnswerIMG($request->file('answerImage'));
        }

        return redirect()->route('bounties.show', $answer->bounty_id)->with('success', 'Answer updated successfully!');
    }

    public function create($bountyId)
    {
        return view('pages.content.answer.create_answer', ['bounty_id' => $bountyId]);
    }

    public function editAnswer($id)
    {
        $answer = Answer::with('content')->findOrFail($id);
        $this->authorize('update', $answer);
        return view('pages.content.answer.edit_answer', compact('answer'));
    }

    public function getAnswer($answerId)
    {
        $answer = Answer::with('content.user')->findOrFail($answerId);
        $bounty = Bounty::with('content')->findOrFail($answer->bounty_id);
        $comments = Comment::with('content.user')->where('answer_id', $answer->id_content)->get();
        return view('pages.content.answer.show_answer', compact('answer', 'comments', 'bounty'));
    }

    public function markCorrect($id)
    {
        try {
            DB::beginTransaction();

            $answer = Answer::with(['content.user', 'bounty'])->findOrFail($id);
            $this->authorize('update', $answer);

            // Check if there's already a correct answer for this bounty
            $existingCorrect = Answer::where('bounty_id', $answer->bounty_id)
                ->where('is_correct', true)
                ->where('id_content', '!=', $id)
                ->first();

            if ($existingCorrect) {
                return response()->json([
                    'error' => 'This bounty already has a correct answer.'
                ], 400);
            }

            // Mark answer as correct
            $answer->is_correct = true;
            $saved = $answer->save();

            Log::info('Answer marked as correct', [
                'answer_id' => $id,
                'saved' => $saved,
                'is_correct_value' => $answer->is_correct
            ]);

            // Award points to the answer's author
            $user = $answer->content->user ?? null;
            if ($user && $answer->bounty) {
                $reward = $answer->bounty->reward ?? 0;
                $user->points = ($user->points ?? 0) + $reward;
                $userSaved = $user->save();

                Log::info('User points updated', [
                    'user_id' => $user->id,
                    'reward' => $reward,
                    'new_points' => $user->points,
                    'saved' => $userSaved
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => 'Answer marked as correct!',
                'points_awarded' => $reward ?? 0
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error marking answer as correct', [
                'answer_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to mark answer as correct: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        $answer = Answer::with('content')->findOrFail($id);
        $this->authorize('delete', $answer);
        $bountyId = $answer->bounty_id;

        $answer->content->delete();
        $answer->delete();

        return redirect()->route('bounties.show', $bountyId)->with('success', 'Answer deleted successfully!');
    }
}
