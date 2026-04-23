<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard (protected)
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/articles/create', [DashboardController::class, 'create'])->name('articles.create');
    Route::post('/articles', [DashboardController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [DashboardController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [DashboardController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [DashboardController::class, 'destroy'])->name('articles.destroy');
});
