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
            //'title' => 'required|string|max:255',
            //'media' => 'nullable|url',
            'description' => 'required|string',
            'bounty_id' => 'required|integer|exists:bounty,id_content',
        ]);

        $content = Content::create([
            'description' => $validatedData['description'],
            'user_id' => Auth::id(),
        ]);

        $answer = Answer::create([
            'id_content' => $content->id,
            'bounty_id' => $validatedData['bounty_id'],
        ]);
        
        return redirect()->route('bounties.show', ['bounty' => $validatedData['bounty_id']]);
    }
}
