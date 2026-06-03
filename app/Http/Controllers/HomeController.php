<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page with the 3 most recent articles.
     */
    public function index()
    {
        $recentPosts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $postsCount = Post::count();
        $commentsCount = Comment::count();
        $authorsCount = User::has('posts')->count();

        return view('home', compact('recentPosts', 'postsCount', 'commentsCount', 'authorsCount'));
    }
}
