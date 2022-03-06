<?php

use Illuminate\Support\Facades\Route;
use Module\User\Http\Controllers\api\v1\UserController;

Route::middleware('auth:sanctum')->group(function (){

    // Paginate Users
    Route::get('all',[UserController::class,'index']);

    // Show User
    Route::get('{user}',[UserController::class,'show']);

    // Update User
    Route::patch('update/{user}',[UserController::class,'update']);
});

require __DIR__ . '/auth_route.php';