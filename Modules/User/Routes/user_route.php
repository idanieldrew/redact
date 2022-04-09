<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\api\v1\UserController;

Route::middleware(['auth:sanctum'])->group(function (){

    // Paginate Users
    Route::get('all',[UserController::class,'index'])->name('user.index');

    // Show User
    Route::get('{user}',[UserController::class,'show'])->name('user.show');

    // Update User
    Route::patch('update/{user}',[UserController::class,'update'])->name('user.update');

    // Destroy User
    Route::delete('destroy/{user}',[UserController::class,'destroy'])->name('user.destroy');

    // Send Sms
    Route::get('send-sms',[UserController::class,'sendSms']);
});