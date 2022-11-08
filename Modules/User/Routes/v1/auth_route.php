<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\auth\v1\AuthController;

// Login
Route::post('login', [AuthController::class, 'login'])->name('login');
// Register
Route::post('register', [AuthController::class, 'register'])->name('register');

require_once 'verify_route.php';
