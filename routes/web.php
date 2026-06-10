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
use App\Http\Controllers\MajorCommentController;
use App\Http\Controllers\MajorRatingController;
use App\Http\Controllers\MajorVideoController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');

// --- Public Category Filter ---
Route::get('categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// --- Majors Routes ---
Route::get('/majors', [MajorController::class, 'index'])->name('majors.index');
Route::get('/majors/{slug}', [MajorController::class, 'show'])->name('majors.show');
Route::middleware('auth')->group(function () {
    Route::post('/majors/{id}/comments', [MajorCommentController::class, 'store'])->name('majors.comments.store');
    Route::post('/majors/{id}/rate', [MajorRatingController::class, 'store'])->name('majors.rate');
    Route::post('/majors/{id}/review', [MajorController::class, 'storeComment'])->name('majors.review.store');
    Route::post('/majors/{id}/video', [MajorVideoController::class, 'upload'])->name('majors.video.upload');
});

// --- Guest Only Routes (Login / Register / Forgot Password) ---
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:auth');

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:auth');

    // --- Password Reset ---
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->middleware('throttle:auth')->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
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

// Original post detail route (uses slug via Post model's getRouteKeyName)
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Static pages (required for seeders)
Route::get('cookies', fn() => view('cookies'))->name('cookies');

// --- Comments Route (public) ---
Route::post('posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('throttle:comments')
    ->name('comments.store');

// --- Rating Route (auth required) ---
Route::middleware('auth')->group(function () {
    Route::post('posts/{post}/rating', [RatingController::class, 'store'])
        ->middleware('throttle:ratings')
        ->name('ratings.store');
});

// --- Formations ---
Route::prefix('formations')->name('formations.')->group(function () {
    Route::get('/',       [FormationController::class, 'index'])->name('index');
    Route::get('/{slug}', [FormationController::class, 'show'])->name('show');
});
