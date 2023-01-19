<?php

use Illuminate\Support\Facades\Route;
use Module\Auth\Http\Controllers\v2\AuthController;
use Module\Auth\Http\Controllers\v2\ForgetPassword;

// Login
Route::post('login.v2', [AuthController::class, 'login'])->name('login.v2');
// Register
Route::post('register.v2', [AuthController::class, 'register'])->name('register.v2');

// Forget password
Route::post('forget-password.v2', [ForgetPassword::class, 'ForgetPassword'])->name('forget-password');

require 'verify_route.php';
