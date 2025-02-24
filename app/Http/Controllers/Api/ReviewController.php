<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\VideoGame;

class ReviewController extends Controller
{
    public function createReview(Request $request, $videoGameId)
    {
        $request->validate([
            'rating' => 'required|numeric|min:0|max:5',
            'review' => 'required|string|min:5',
        ]);

        $videoGame = VideoGame::findOrFail($videoGameId);

        // Check if the user has already reviewed this game
        if (Review::where('user_id', auth()->id())->where('video_game_id', $videoGameId)->exists()) {
            return response()->json(['message' => 'You have already reviewed this game.'], 409);
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'video_game_id' => $videoGame->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json(['message' => 'Review added successfully', 'review' => $review], 201);
    }

    public function updateReview(Request $request, $id)
    {
        $review = Review::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'rating' => 'numeric|min:0|max:5',
            'review' => 'string|min:5',
        ]);

        $review->update($request->only(['rating', 'review']));

        return response()->json(['message' => 'Review updated successfully', 'review' => $review], 200);
    }

    public function deleteReview($id)
    {
        $review = Review::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }

    public function getReviewsForGame($videoGameId)
    {
        $reviews = Review::where('video_game_id', $videoGameId)->with('user')->get();
        return response()->json($reviews, 200);
    }
}
