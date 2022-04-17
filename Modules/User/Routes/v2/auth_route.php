<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\auth\v2\AuthController;

// Login
Route::post('login.v2',[AuthController::class,'login'])->name('login.v2');

// Register
Route::post('register.v2',[AuthController::class,'register'])->name('register.v2');

