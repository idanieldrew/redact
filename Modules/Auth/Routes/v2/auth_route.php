<?php

use Illuminate\Support\Facades\Route;
use Module\Auth\Http\Controllers\v2\AuthController;
use Module\Auth\Http\Controllers\v2\ForgetPsdController;

// Login
Route::post('login.v2', [AuthController::class, 'login'])->name('login.v2');
// Register
Route::post('register.v2', [AuthController::class, 'register'])->name('register.v2');

// Forget password
Route::post('forget-password.v2', [ForgetPsdController::class, 'forgetPassword'])->name('forget-password');
// Verify forget password
Route::post('verify.forget-password.v2', [ForgetPsdController::class, 'verifyForgetPsd'])->name('verify-forget-psd');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('change_password.v2', [\Module\Auth\Http\Controllers\v2\ChangePsdController::class, 'changPsd'])->name('chang-psd');
});
require 'verify_route.php';
