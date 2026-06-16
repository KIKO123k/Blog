<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\UserNotification;
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

        // Notifier l'auteur de l'article (sauf s'il commente le sien)
        if ($post->user_id && $post->user_id !== Auth::id()) {
            $commenter = Auth::check() ? Auth::user()->name : ($validated['author_name'] ?? 'Un visiteur');
            UserNotification::send($post->user_id, $commenter . ' a commenté votre article', [
                'body'  => \Illuminate\Support\Str::limit($post->title, 60),
                'url'   => route('posts.show', $post->slug ?? $post->id),
                'icon'  => 'comment',
                'color' => '#d97706',
            ]);
        }

        return back()->with('success', 'Votre commentaire a été publié avec succès !');
    }
}
