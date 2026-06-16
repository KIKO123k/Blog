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
        // Eager load 'user' pour éviter le problème N+1 dans la boucle des articles
        $posts = Post::with('user')->withAvg('ratings as average_rating', 'rating')->latest()->take(3)->get();

        $postsCount = Post::count();
        $commentsCount = Comment::count();
        $usersCount = User::has('posts')->count();

        $formations = \App\Models\Formation::where('category', 'cycle_ingenieur')->get();

        return view('home', compact('posts', 'postsCount', 'commentsCount', 'usersCount', 'formations'));
    }
}
