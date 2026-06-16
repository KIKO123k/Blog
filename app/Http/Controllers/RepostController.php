<?php

namespace App\Http\Controllers;

use App\Models\Post;

class RepostController extends Controller
{
    /** Ajoute / retire un article des articles repostés sur le portfolio. */
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($user->hasReposted($post->id)) {
            $user->reposts()->detach($post->id);
            return back()->with('success', 'Article retiré de votre portfolio.');
        }

        $user->reposts()->attach($post->id);
        return back()->with('success', 'Article reposté sur votre portfolio !');
    }
}
