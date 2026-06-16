<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');

        // Retrieve posts with relationship eager loading (N+1 query safety), paginated
        $posts = Post::with('user')
            ->withAvg('ratings as average_rating', 'rating')
            ->withCount('ratings as ratings_count')
            ->withCount('comments as comments_count')
            ->when($search, function ($query, $search) {
                // Search in title, content, or author name
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('content', 'like', '%' . $search . '%')
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'like', '%' . $search . '%');
                      });
                });
            })
            ->when($categorySlug, function ($query, $categorySlug) {
                return $query->whereHas('categories', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('posts.index', compact('posts', 'search', 'categories', 'categorySlug'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        // Auto-assign the logged-in user as the author
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post = Post::create($validated);

        if (!empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return redirect()->route('posts.show', $post)->with('success', 'L\'article a été créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Load the user, comments, and ratings relations for the single post view
        $post->load(['user', 'comments', 'ratings', 'categories']);
        $post->loadAvg('ratings as average_rating', 'rating');
        $post->loadCount('ratings as ratings_count');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Guard: Verify ownership or admin via Gate
        if (! Gate::allows('update', $post)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cet article.');
        }

        $post->load('categories');
        $categories = Category::orderBy('name')->get();
        $selectedCategoryIds = $post->categories->pluck('id')->toArray();

        return view('posts.edit', compact('post', 'categories', 'selectedCategoryIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Guard: Verify ownership or admin via Gate
        if (! Gate::allows('update', $post)) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cet article.');
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image from storage if it exists
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post->update($validated);

        $post->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('posts.show', $post)->with('success', 'L\'article a été mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Guard: Verify ownership or admin via Gate
        if (! Gate::allows('delete', $post)) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cet article.');
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'L\'article a été supprimé avec succès !');
    }
}
