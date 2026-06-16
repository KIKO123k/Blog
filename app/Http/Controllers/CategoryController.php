<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display posts that belong to a given category.
     */
    public function show(Request $request, Category $category)
    {
        $search = $request->input('search');

        $posts = $category->posts()
            ->with('user')
            ->withAvg('ratings as average_rating', 'rating')
            ->withCount('ratings as ratings_count')
            ->withCount('comments as comments_count')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('posts.index', [
            'posts' => $posts,
            'search' => $search,
            'categories' => $categories,
            'categorySlug' => $category->slug,
            'activeCategory' => $category,
        ]);
    }
}
