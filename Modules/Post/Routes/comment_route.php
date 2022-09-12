<?php

use Illuminate\Support\Facades\Route;
use Module\Post\Http\Controllers\api\v1\CommentController;

// Add Comment
Route::prefix('{post:slug}/comment')->group(function () {
    // Create comment
    Route::post('/', [CommentController::class, 'store'])->name('post.store_comment');
    // Comments for post
    Route::get('/',[CommentController::class,'index','index'])->name('post.index_comment');
    // Reply comment
    Route::post('/{comment}', [CommentController::class, 'reply'])->name('post.reply_comment');
});
