<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Major;
use App\Models\Formation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search across posts, majors, and formations.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $type = $request->input('type', 'all'); // posts, majors, formations, all

        if (strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Query must be at least 2 characters',
            ], 400);
        }

        $results = [];

        if ($type === 'all' || $type === 'posts') {
            $results['posts'] = Post::where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%")
                ->limit(10)
                ->get(['id', 'title', 'slug', 'created_at']);
        }

        if ($type === 'all' || $type === 'majors') {
            $results['majors'] = Major::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->limit(10)
                ->get(['id', 'name', 'slug', 'created_at']);
        }

        if ($type === 'all' || $type === 'formations') {
            $results['formations'] = Formation::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->limit(10)
                ->get(['id', 'name', 'slug', 'created_at']);
        }

        return response()->json([
            'success' => true,
            'data' => $results,
            'meta' => [
                'query' => $query,
                'type' => $type,
            ],
        ]);
    }
}