<?php

use Illuminate\Support\Facades\Route;
use Module\Post\Http\Controllers\api\v1\CommentController;

// Add Comment
Route::prefix('{post:slug}/comment')->group(function () {
    Route::post('/', [CommentController::class, 'create_comment'])->name('post.create_comment');
    // Reply comment
    Route::post('/{comment}', [CommentController::class, 'reply_comment'])->name('post.reply_comment');
});
