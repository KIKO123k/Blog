<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $validated = $request->validated();

        // post_id and (when available) user_id come from server-side context, not user input
        $validated['post_id'] = $post->id;
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        $post->comments()->create($validated);

        return back()->with('success', 'Votre commentaire a été publié avec succès !');
    }
}
