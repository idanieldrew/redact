<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\auth\v2\AuthController;

// Login
Route::post('login',[AuthController::class,'login'])->name('login.v2');

// Register
Route::post('register',[AuthController::class,'register'])->name('register.v2');

