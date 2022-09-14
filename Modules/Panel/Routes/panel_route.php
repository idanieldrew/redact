<?php

use Illuminate\Support\Facades\Route;
use Module\Panel\Http\Controllers\api\v1\AdminController;

Route::post('ceremony', [AdminController::class, 'ceremony'])->name('ceremony.message');
