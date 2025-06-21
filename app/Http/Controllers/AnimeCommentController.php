<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class AnimeCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
            'specs' => 1,
            'user_id' => $request->user()->id,
            'parent_id' => $request->parent_id, // it comes when is comment is reply
            'commentable_id' => $request->anime_id,
            'comment_type_id' => 1, // 1 is anime, 2 is episode
            'comment' => $request->content,
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
    public function destroy(Comment $comment, Request $request)
    {
        if ($comment->user_id !== $request->user()->id) {
            return response_error('You are not allowed to delete this comment', 403);
        }

        $comment->delete();

        return response_success([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
