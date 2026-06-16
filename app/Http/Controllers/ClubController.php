<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Http\Requests\StoreClubRequest;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        $query = Club::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('acronym', 'like', "%{$term}%");
            });
        }

        $clubs = $query->latest()->paginate(12)->withQueryString();

        return view('clubs.index', compact('clubs'));
    }

    public function show(Club $club)
    {
        $bureau    = $club->bureau()->get();
        $adherents = $club->adherents()->get();
        $events    = $club->events()->upcoming()->withCount('participants')->get();

        return view('clubs.show', compact('club', 'bureau', 'adherents', 'events'));
    }

    public function store(StoreClubRequest $request)
    {
        $club = Club::create($request->validated());
        return response()->json($club, 201);
    }
}
