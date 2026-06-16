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
     * Route is already wrapped in 'auth' middleware, so $user is guaranteed.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        // Create or update rating (one rating per user per post)
        Rating::updateOrCreate(
            ['user_id' => $user->id, 'post_id' => $post->id],
            ['rating' => $validated['rating']]
        );

        return redirect()->back()->with('success', 'Merci pour votre avis !');
    }
}
