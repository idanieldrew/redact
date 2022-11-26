<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Module\Category\Models\Category;
use Module\Premium\Database\Seeders\PremiumDatabaseSeeder;
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
        $this->call(PremiumDatabaseSeeder::class);
        User::factory(['role_id' => 1])->create();

        $names = ['sport', 'science', 'imaginary'];
        foreach ($names as $name) {
            Category::factory(['name' => $name, 'user_id' => 1])->create();
        }
    }
}
