<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentVote;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function vote(Request $request, Content $content)
    {
        $request->validate([
            'vote' => 'required|integer|in:-1,0,1'
        ]);

        $user = $request->user();
        $voteType = $request->vote;

        if ($voteType == 0) {
            ContentVote::where('user_id', $user->id)
                ->where('content_id', $content->id)
                ->delete();
        } else {
            DB::table('content_vote')->updateOrInsert(
                ['user_id' => $user->id, 'content_id' => $content->id],
                ['vote' => $voteType]
            );
        }

        return response()->json([
            'success' => true,
            'rating' => $content->rating()
        ]);
    }
}
