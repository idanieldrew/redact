<?php

use Illuminate\Support\Facades\Route;
use Module\Plan\Http\Controllers\v1\PlanController;

// store panel
Route::post('', [PlanController::class, 'store'])->middleware('auth:sanctum')->name('plan.store');
