<?php

// Store post
use Illuminate\Support\Facades\Route;
use Module\Image\Http\Controllers\api\v1\ImageController;

Route::post('image',[ImageController::class,'store'])->name('image.store');