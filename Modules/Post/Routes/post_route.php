<?php

use Illuminate\Support\Facades\Route;
use Module\Post\Http\Controllers\api\v1\PostController;

Route::middleware('auth:sanctum')->group(function (){
    // All posts
    Route::get('/all',[PostController::class,'index'])->name('post.index');

    // Store post
    Route::post('/store',[PostController::class,'store'])->name('post.store');
});
