<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\api\v1\UserController;

// Paginate Users
Route::get('/all',[UserController::class,'index']);

// Show Users
Route::get('/{user}',[UserController::class,'show']);
