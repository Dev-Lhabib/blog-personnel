<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('articles.index'));

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Public article routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/articles/create', [DashboardController::class, 'create'])->name('articles.create');
    Route::post('/articles', [DashboardController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [DashboardController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [DashboardController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [DashboardController::class, 'destroy'])->name('articles.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
