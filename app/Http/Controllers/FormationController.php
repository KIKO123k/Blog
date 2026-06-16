<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $formations = Formation::when($category, fn($q) => $q->where('category', $category))
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderByRaw("FIELD(category, 'preparatoire', 'cycle_ingenieur', 'formation_continue', 'doctorat')")
            ->orderBy('title')
            ->get()
            ->groupBy('category');

        $categories = [
            'preparatoire'       => 'Années Préparatoires',
            'cycle_ingenieur'    => 'Cycle Ingénieur',
            'formation_continue' => 'Formation Continue',
            'doctorat'           => 'Cycle Doctoral',
        ];

        return view('formations.index', compact('formations', 'categories', 'category', 'search'));
    }

    public function show(string $slug)
    {
        $formation = Formation::where('slug', $slug)->firstOrFail();
        return view('formations.show', compact('formation'));
    }
}
