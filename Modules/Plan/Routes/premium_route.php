<?php

use Illuminate\Support\Facades\Route;

Route::post('',function () {
    \Module\Premium\Models\Plan::create([
       'name' => 'test',
       'details' => 'test test',
       'price' => '111',
        'user_id' => 1
    ]);
    return;
})->middleware('auth:sanctum')->name('premium.store');
