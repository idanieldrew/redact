<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\auth\v1\VerifyController;

Route::get('/email/verify', function () {
//    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerifyController::class, 'verify'])->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [VerifyController::class, 'send'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
