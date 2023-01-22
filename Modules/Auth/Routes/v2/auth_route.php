<?php

use Illuminate\Support\Facades\Route;
use Module\Auth\Http\Controllers\v2\AuthController;
use Module\Auth\Http\Controllers\v2\ForgetPassword;

// Login
Route::post('login.v2', [AuthController::class, 'login'])->name('login.v2');
// Register
Route::post('register.v2', [AuthController::class, 'register'])->name('register.v2');

// Forget password
Route::post('forget-password.v2', [ForgetPassword::class, 'forgetPassword'])->name('forget-password');
// Verify forget password
Route::post('verify.forget-password.v2', [ForgetPassword::class, 'verifyForgetPsd'])->name('verify-forget-psd');

require 'verify_route.php';
