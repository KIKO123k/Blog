<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Page d'accueil : Liste des articles
Route::get('/', [PostController::class, 'index']);

// CRUD complet pour les articles (index, create, store, show, edit, update, destroy)
Route::resource('posts', PostController::class);
