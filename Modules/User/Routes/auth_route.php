<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\auth\v1\LoginController;
use Module\User\Http\Controllers\auth\v1\RegisterController;

// Login
Route::post('/login',[LoginController::class,'login'])->name('login');

// Register
Route::post('register',[RegisterController::class,'register'])->name('register');