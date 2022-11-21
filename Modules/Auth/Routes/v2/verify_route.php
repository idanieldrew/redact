<?php

use Illuminate\Support\Facades\Route;
use Module\Auth\Http\Controllers\v2\VerifyController;

Route::get('/email/verify/v2/{user}', [VerifyController::class, 'verify'])
    ->middleware(['auth:sanctum', 'signed'])
    ->name('verify.v2');
