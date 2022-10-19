<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\api\v1\UserController;

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    // Paginate Users
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    // Show User
    Route::get('{user}', [UserController::class, 'show'])->name('user.show');
    // Update User
    Route::patch('{user}', [UserController::class, 'update'])->name('user.update');
    // Destroy User
    Route::delete('{user}', [UserController::class, 'destroy'])->name('user.destroy');
    // Send Sms
    Route::get('send/sms', [UserController::class, 'sendSms'])->name('send-sms');
});
