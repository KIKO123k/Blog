<?php

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
    // Posts API (placeholder - implement controllers as needed)
    Route::get('posts', fn() => response()->json(['message' => 'Posts endpoint']));
    Route::get('posts/{id}', fn($id) => response()->json(['message' => "Post {$id}"]));

    // Search API with dedicated rate limit (30/minute)
    Route::middleware('throttle:search')->group(function () {
        Route::get('search', fn() => response()->json(['message' => 'Search endpoint']));
    });
});