<?php

use Illuminate\Support\Facades\Route;
use Module\Category\Http\Controllers\api\v1\CategoryController;
use Module\Category\Models\Category;

// All posts
/*Route::get('/', function () {
    $category = Category::first();

//    $category->setTranslation('name', 'ul', "اکیه");

    $name = [
        "en" => "test 1",
        "sp" => "test 2"
    ];
    Category::query()->create([
        'name' => $name,
        'user_id' => 1,
    ]);

    dd(77);

    echo 'ok';
//    echo $category->getTranslation('name', 'fa');
});*/

Route::get('/', [CategoryController::class, 'index'])->name('category.index');
// Show category
Route::get('{category:slug}', [CategoryController::class, 'show'])->name('category.show');

Route::middleware(['auth:sanctum'])->group(function () {
    // Show category
    Route::post('/', [CategoryController::class, 'store'])->name('category.store');
    // Update category
    Route::patch('update/{category:slug}', [CategoryController::class, 'update'])->name('category.update');
});
