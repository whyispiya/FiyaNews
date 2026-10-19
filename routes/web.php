<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

// 🏠 Homepage
Route::get('/', [ArticleController::class, 'index'])
    ->name('articles.index');

// 📰 Article Routes (Sudah Diurutkan dengan Benar)
Route::prefix('articles')->name('articles.')->group(function () {

    Route::get('/create', [ArticleController::class, 'create'])
        ->name('create');

    Route::post('/', [ArticleController::class, 'store'])
        ->name('store');

    // 🔒 Fitur yang butuh login ditaruh di sini sebelum rute {article} wildcard
    Route::middleware('auth')->group(function () {
        Route::post('/{id}/like', [ArticleController::class, 'like'])
            ->name('like');

        Route::post('/{id}/comments', [CommentController::class, 'store'])
            ->name('comment.store'); // Ubah nama rute agar mengikuti prefix articles.
    });

    // 👁️ Rute wildcard ditaruh paling bawah agar tidak memakan rute lain
    Route::get('/{article}', [ArticleController::class, 'show'])
        ->name('show');

    Route::get('/{article}/edit', [ArticleController::class, 'edit'])
        ->name('edit');

    Route::put('/{article}', [ArticleController::class, 'update'])
        ->name('update');

    Route::delete('/{article}', [ArticleController::class, 'destroy'])
        ->name('destroy');
});

// 📂 Category Route
Route::get('/category/{category}', [ArticleController::class, 'category'])
    ->name('category');

// 👤 Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';