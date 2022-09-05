<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        User::factory(['role_id' => 1])->create();
    }
}
