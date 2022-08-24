<?php

use Illuminate\Support\Facades\Route;
use Module\Post\Http\Controllers\api\v1\PostController;

Route::get('/test/{post:slug}', function ($lang, \Module\Post\Models\Post $post) {
    dd($lang, $post);
});

// Posts
Route::get('/', [PostController::class, 'index'])->name('post.index');
// Search posts
Route::get('search', [PostController::class, 'search'])->name('post.search');
// Post
Route::get('{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('{code}', [PostController::class, 'short_link'])->name('post.show');

Route::middleware(['auth:sanctum'])->group(function () {
    // Store post
    Route::post('/', [PostController::class, 'store'])->name('post.store');
    // Update post
    Route::patch('{post:slug}', [PostController::class, 'update'])->name('post.update');
    // Destroy post
    Route::delete('{post:slug}', [PostController::class, 'destroy'])->name('post.destroy');
});
