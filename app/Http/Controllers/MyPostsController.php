<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyPostsController extends Controller
{
    /**
     * Display a paginated list of the logged‑in user's posts with comments.
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)
            ->with('comments')
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('posts.my_posts', compact('posts'));
    }
}
