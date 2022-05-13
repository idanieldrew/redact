<?php

use Illuminate\Support\Facades\Route;
use Module\Category\Http\Controllers\api\v1\CategoryController;

// All posts
Route::get('all',[CategoryController::class,'index'])->name('category.index');

// Show category
Route::get('{category:slug}',[CategoryController::class,'show'])->name('category.show');