<?php

use Illuminate\Support\Facades\Route;
use Module\Post\Http\Controllers\api\v1\PostController;

// All posts
Route::get('all',[PostController::class,'index'])->name('post.index');

// Search posts
Route::get('search',[PostController::class,'search'])->name('post.search');

// Single post
Route::get('{post:slug}',[PostController::class,'show'])->name('post.show');

Route::middleware(['auth:sanctum'])->group(function (){
        // Store post
        Route::post('store',[PostController::class,'store'])->name('post.store');

        // Update post
        Route::patch('update/{post:slug}',[PostController::class,'update'])->name('post.update');

        // Destroy post
        Route::delete('destroy/{post:slug}',[PostController::class,'destroy'])->name('post.destroy');
});