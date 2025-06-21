<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class AnimeEpisodeCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable',
            'episode_id' => 'required',
        ]);

        $comment = Comment::create([
            'specs' => 1,
            'user_id' => auth()->user()->id,
            'parent_id' => $request->parent_id, // it comes when is comment is reply
            'commentable_id' => $request->episode_id,
            'comment_type_id' => 2, // 1 is anime, 2 is episode
            'comment' => $request->comment,
        ]);

        return response_success([
            'message' => 'Comment created successfully',
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->user()->id) {
            return response_error('You are not authorized to delete this comment');
        }

        $comment->delete();

        return response_success([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
