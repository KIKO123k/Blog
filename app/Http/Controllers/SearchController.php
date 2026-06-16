<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Major;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Recherche globale : articles, filières, clubs et étudiants.
 */
class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $posts = $majors = $clubs = $students = collect();

        if (mb_strlen($q) >= 2) {
            $like = "%{$q}%";

            $posts = Post::where('title', 'like', $like)
                ->orWhere('content', 'like', $like)
                ->latest()->limit(8)->get();

            $majors = Major::where('title', 'like', $like)
                ->orWhere('description', 'like', $like)->limit(6)->get();

            $clubs = Club::where('name', 'like', $like)
                ->orWhere('acronym', 'like', $like)
                ->orWhere('description', 'like', $like)->limit(6)->get();

            $students = User::where('account_type', 'student')
                ->where(fn ($w) => $w->where('name', 'like', $like)->orWhere('filiere', 'like', $like))
                ->limit(8)->get();
        }

        $total = $posts->count() + $majors->count() + $clubs->count() + $students->count();

        return view('search.index', compact('q', 'posts', 'majors', 'clubs', 'students', 'total'));
    }
}
