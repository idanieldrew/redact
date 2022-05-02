<?php

namespace Module\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Module\Category\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(7)->create();
    }
}
