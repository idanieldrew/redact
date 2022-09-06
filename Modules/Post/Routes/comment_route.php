<?php

use Illuminate\Support\Facades\Route;
use Module\Post\Http\Controllers\api\v1\PostController;

// Add Comment
Route::prefix('{post:slug}/comment')->group(function () {
    Route::post('/', [PostController::class, 'create_comment'])->name('post.create_comment');
});
