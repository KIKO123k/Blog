<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MajorResource;
use App\Models\Major;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MajorApiController extends Controller
{
    /**
     * Display a listing of all majors.
     */
    public function index(): JsonResponse
    {
        $majors = Major::withCount(['ratings', 'comments'])
            ->orderBy('title')
            ->get();

        return response()->json([
            'data' => MajorResource::collection($majors),
            'meta' => [
                'total' => $majors->count(),
            ],
        ]);
    }

    /**
     * Display the specified major.
     */
    public function show(string $slug): JsonResponse
    {
        $major = Major::with(['comments.user', 'ratings'])
            ->withCount(['ratings', 'comments'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'data' => new MajorResource($major),
        ]);
    }
}