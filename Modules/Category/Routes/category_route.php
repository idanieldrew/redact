<?php

use Illuminate\Support\Facades\Route;
use Module\Category\Http\Controllers\api\v1\CategoryController;

// All posts
Route::get('all',[CategoryController::class,'index'])->name('category.index');

// Show category
Route::get('{category:slug}',[CategoryController::class,'show'])->name('category.show');

Route::middleware(['auth:sanctum'])->group(function () {
    // Show category
    Route::post('store',[CategoryController::class,'store'])->name('category.store');

    // Update category
    Route::patch('update/{category:slug}',[CategoryController::class,'update'])->name('category.update');
});