<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content_id' => 'required|integer|exists:content,id',
            'text' => 'required|string|max:400',
            'answer_id' => 'nullable|integer|exists:answer,id_content',
            'parent_id' => 'nullable|integer|exists:comment,id_content',
        ]);

        $user = $request->user();
        $parentContentId = $request->input('content_id'); 
        $answerId = $request->input('answer_id');
        $parentId = $request->input('parent_id');

        
        $newContent = Content::create([
            'description' => $request->input('text'),
            'user_id' => $user->id,
        ]);

        $newComment = Comment::create([
            'id_content' => $newContent->id,
            'bounty_id' => $parentContentId,
            'answer_id' => $answerId ?: null,
            'parent_id' => $parentId ?: null,
        ]);

        $created = ['content_id' => $newContent->id, 'bounty_id' => $parentContentId];

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function editForm($id)
    {
        $comment = Comment::with('content')->findOrFail($id);
        return view('pages.content.comment.edit_comment', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:400',
        ]);

        $comment = Comment::with('content')->findOrFail($id);
        $comment->content->description = $request->input('text');
        $comment->content->updated_at = now();
        $comment->content->save();

        if (!empty($comment->bounty_id)) {
            return redirect()->route('bounties.show', $comment->bounty_id)
                ->with('success', 'Comment updated successfully.');
        }

 
        return redirect()->back()->with('success', 'Comment updated successfully.');
    }


    public function delete($id)
    {
        $comment = Comment::with('content')->findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
