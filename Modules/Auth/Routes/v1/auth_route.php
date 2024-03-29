<?php

use Illuminate\Support\Facades\Route;
use Module\Auth\Http\Controllers\v1\AuthController;

// Login
Route::post('login', [AuthController::class, 'login'])->name('login');
// Register
Route::post('register', [AuthController::class, 'register'])->name('register');

require 'verify_route.php';
