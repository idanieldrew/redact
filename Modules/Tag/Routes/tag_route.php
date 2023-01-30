<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    // all tags
    Route::get('/tags', [\Module\Tag\Http\Controllers\api\v1\TagController::class, 'index'])->name('tag.index');
});
