<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyPostsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\MajorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('majors/{slug}', [MajorController::class, 'show'])->name('majors.show');

// --- Guest Only Routes (Login / Register) ---
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// --- Authenticated Authors Only Routes ---
Route::middleware('auth')->group(function () {
    // CRUD Create/Edit/Store/Update/Destroy operations
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // My Articles page
    Route::get('my-articles', [MyPostsController::class, 'index'])->name('my-articles');

    // Profile operations
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Secure POST logout route
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Original post detail route (numeric IDs)
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Static pages (required for seeders)
Route::get('cookies', fn() => view('cookies'))->name('cookies');

// --- Comments Route ---
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('posts/{post}/rating', [RatingController::class, 'store'])->name('ratings.store');
