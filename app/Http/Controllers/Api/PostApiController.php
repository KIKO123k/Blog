<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostApiController extends Controller
{
    /**
     * Display a listing of posts with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->get('per_page', 15), 100);

        $posts = Post::with(['user', 'categories'])
            ->withAvg('ratings as average_rating', 'rating')
            ->withCount('ratings as ratings_count')
            ->withCount('comments as comments_count')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json((new PostCollection($posts))->response()->getData(true));
    }

    /**
     * Display the specified post.
     */
    public function show(string $slug): JsonResponse
    {
        $post = Post::with(['user', 'categories', 'comments.user'])
            ->withAvg('ratings as average_rating', 'rating')
            ->withCount('ratings as ratings_count')
            ->withCount('comments as comments_count')
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'data' => new PostResource($post),
        ]);
    }

    /**
     * Store a newly created post (auth required).
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post = Post::create($validated);

        if (!empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        $post->load(['user', 'categories']);
        $post->loadAvg('ratings as average_rating', 'rating');
        $post->loadCount('ratings as ratings_count');
        $post->loadCount('comments as comments_count');

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post created successfully.',
        ], 201);
    }

    /**
     * Update the specified post (owner only).
     */
    public function update(UpdatePostRequest $request, string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden. You are not the owner.'], 403);
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post->update($validated);
        $post->categories()->sync($validated['categories'] ?? []);

        $post->load(['user', 'categories']);
        $post->loadAvg('ratings as average_rating', 'rating');
        $post->loadCount('ratings as ratings_count');
        $post->loadCount('comments as comments_count');

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post updated successfully.',
        ]);
    }

    /**
     * Remove the specified post (owner only).
     */
    public function destroy(string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden. You are not the owner.'], 403);
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.',
        ]);
    }
}