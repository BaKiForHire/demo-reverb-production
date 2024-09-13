<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, $auctionId)
    {
        $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        $isSeller = Auth::user()->id === $request->auction->user_id;

        Comment::create([
            'user_id' => Auth::id(),
            'auction_id' => $auctionId,
            'comment_text' => $request->comment_text,
            'is_seller' => $isSeller,
        ]);

        return response()->json(['message' => 'Comment posted successfully']);
    }

    /**
     * Upvote a comment.
     */
    public function upvote($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->increment('upvotes');

        return response()->json(['message' => 'Comment upvoted']);
    }
}

