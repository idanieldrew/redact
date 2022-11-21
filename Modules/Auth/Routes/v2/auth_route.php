<?php

use Illuminate\Support\Facades\Route;
use Module\Auth\Http\Controllers\v2\AuthController;

// Login
Route::post('login.v2', [AuthController::class, 'login'])->name('login.v2');
// Register
Route::post('register.v2', [AuthController::class, 'register'])->name('register.v2');

require 'verify_route.php';
