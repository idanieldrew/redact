<?php

use Illuminate\Support\Facades\Route;
use Module\Token\Http\Controllers\api\v1\TokenController;
use Module\User\Http\Controllers\api\v1\UserController;

Route::middleware(['auth:sanctum'])->group(function () {
    // Send Sms
    Route::post('otp', [TokenController::class, 'otp']);
});
