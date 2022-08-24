<?php

use Illuminate\Support\Facades\Route;
use Module\Post\Http\Controllers\api\v1\PostController;

// Short link
Route::get('{link}', [PostController::class, 'short_link'])->name('post.short_link');
