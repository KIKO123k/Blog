<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormationResource;
use App\Models\Formation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormationApiController extends Controller
{
    /**
     * Display a listing of all formations.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Formation::query();

        if ($request->has('category')) {
            $query->where('category', $request->get('category'));
        }

        $formations = $query->orderByRaw("FIELD(category, 'preparatoire', 'cycle_ingenieur', 'formation_continue', 'doctorat')")
            ->orderBy('title')
            ->get();

        return response()->json([
            'data' => FormationResource::collection($formations),
            'meta' => [
                'total' => $formations->count(),
            ],
        ]);
    }

    /**
     * Display the specified formation.
     */
    public function show(string $slug): JsonResponse
    {
        $formation = Formation::where('slug', $slug)->firstOrFail();

        return response()->json([
            'data' => new FormationResource($formation),
        ]);
    }
}