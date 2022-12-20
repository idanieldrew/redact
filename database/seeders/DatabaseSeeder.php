<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Module\Category\Models\Category;
use Module\Plan\Database\Seeders\PlanTableSeeder;
use Module\Role\Database\Seeders\RoleTableSeeder;
use Module\User\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(PlanTableSeeder::class);

        $names = ['sport', 'science', 'imaginary'];
        foreach ($names as $name) {
            User::first()->categories()->create([
                'name' => $name
            ]);
        }
    }
}
