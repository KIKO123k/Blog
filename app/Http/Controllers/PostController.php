<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Retrieve posts with relationship eager loading (N+1 query safety), paginated
        $posts = Post::with('user')
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->withQueryString();

        return view('posts.index', compact('posts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Auto-assign the logged-in user as the author
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', 'L\'article a été créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Load the user, comments, and ratings relations for the single post view
        $post->load(['user', 'comments', 'ratings']);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Guard: Verify ownership
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cet article.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Guard: Verify ownership
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cet article.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image from storage if it exists
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post->id)->with('success', 'L\'article a été mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Guard: Verify ownership
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cet article.');
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'L\'article a été supprimé avec succès !');
    }
}
