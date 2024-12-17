<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(string $productId){
        $comments = Reviews::with('user')
        ->where('product_id', $productId)
        ->where('status', 1)
        ->orderBy('id', 'desc')
        ->limit(3)
        ->get()
        ->map(function ($comment) {
            return [
                'id' => $comment->id,
                'rating' => $comment->rating,
                'review_text' => $comment->review_text,
                'user_id' => $comment->user_id,
                'username' => $comment->user->name,
            ];
        });
    return response()->json($comments);
    }
    public function comment_stats(string $productId) {
        $ratings = Reviews::select('rating')
        ->where('product_id', $productId)
        ->groupBy('rating')
        ->where('status', 1)
        ->orderBy('rating', 'desc')
        ->get()
        ->map(function ($review) {
            return [
                'stars' => $review->rating,
                'count' => Reviews::where('product_id', $productId)
                    ->where('rating', $review->rating)
                    ->where('status', 1)
                    ->count(),
            ];
        });

    return response()->json($ratings);
    }
    public function add_comment(Request $request){
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review_text' => 'required|string|max:500',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);
        $comment = Reviews::create([
            'rating' => $validatedData['rating'],
            'review_text' => $validatedData['review_text'],
            'user_id' => $validatedData['user_id'],
            'product_id' => $validatedData['product_id'],
            'status' => 1,
        ]);
    
        return response()->json([
            'message' => 'Bình luận đã được gửi thành công!',
            'comment' => $comment
        ], 201);
    }
}
