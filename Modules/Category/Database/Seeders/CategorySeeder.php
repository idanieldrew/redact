<?php

namespace Module\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Module\Category\Models\Category;
use Module\Image\Models\Image;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(7)->create()->each(function ($category){
            $category->images()->save(Image::factory()->make());
        });

    }
}