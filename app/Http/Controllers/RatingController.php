<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store or update a rating for a post by the authenticated user.
     */
    public function store(Request $request, Post $post)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour noter un article.');
        }

        // Validate rating value (1-5)
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Create or update rating (one rating per user per post)
        Rating::updateOrCreate(
            ['user_id' => $user->id, 'post_id' => $post->id],
            ['rating' => $validated['rating']]
        );

        return redirect()->back()->with('success', 'Merci pour votre avis !');
    }
}
