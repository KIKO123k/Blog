<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\FormationApiController;
use App\Http\Controllers\Api\MajorApiController;
use App\Http\Controllers\Api\PostApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded with the "api" middleware group which provides
| global rate limiting (60 requests per minute).
|
| Individual routes can have additional rate limiters applied as needed.
|
*/

Route::middleware('throttle:api')->group(function () {
    // Posts API
    Route::get('posts', [PostApiController::class, 'index']);
    Route::get('posts/{slug}', [PostApiController::class, 'show'])->where('slug', '.*');
    Route::post('posts', [PostApiController::class, 'store'])->middleware('auth:sanctum');
    Route::put('posts/{slug}', [PostApiController::class, 'update'])->middleware('auth:sanctum')->where('slug', '.*');
    Route::delete('posts/{slug}', [PostApiController::class, 'destroy'])->middleware('auth:sanctum')->where('slug', '.*');

    // Majors API
    Route::get('majors', [MajorApiController::class, 'index']);
    Route::get('majors/{slug}', [MajorApiController::class, 'show'])->where('slug', '.*');

    // Formations API
    Route::get('formations', [FormationApiController::class, 'index']);
    Route::get('formations/{slug}', [FormationApiController::class, 'show'])->where('slug', '.*');

    // Categories API
    Route::get('categories', [CategoryApiController::class, 'index']);

    // Search API with dedicated rate limit (30/minute)
    Route::middleware('throttle:search')->group(function () {
        Route::get('search', fn () => response()->json(['message' => 'Search endpoint']));
    });
});