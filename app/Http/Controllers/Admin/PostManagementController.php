<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostManagementController extends Controller
{
    /**
     * List all posts.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }
}