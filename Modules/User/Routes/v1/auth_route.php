<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\auth\v1\AuthController;
use Module\User\Http\Controllers\auth\v1\VerifyController;

// Login
Route::post('login',[AuthController::class,'login'])->name('login');

// Register
Route::post('register',[AuthController::class,'register'])->name('register');

// Verification mail
Route::get('/email/verify',[VerifyController::class,'notice'])->middleware('auth:sanctum')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}',[VerifyController::class,'verify'])->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [VerifyController::class,'send'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');