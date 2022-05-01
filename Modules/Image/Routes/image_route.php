<?php

// Store post
use Illuminate\Support\Facades\Route;
use Module\Image\Http\Controllers\api\v1\ImageController;

Route::post('store',[ImageController::class,'store'])->name('image.store');