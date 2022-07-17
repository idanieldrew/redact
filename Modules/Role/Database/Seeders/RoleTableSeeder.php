<?php

namespace Module\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Module\Role\Models\Permission;
use Module\Role\Models\Role;
use Module\User\Models\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        $p1 = Permission::create(['name' => 'edit articles']);
        $p2 = Permission::create(['name' => 'delete articles']);
        $p3 = Permission::create(['name' => 'publish articles']);
        $p4 = Permission::create(['name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);

        $role1->permissions()->attach([$p1->id, $p2->id]);

        $role2 = Role::create(['name' => 'admin']);
        $role2->permissions()->sync([$p3->id, $p4->id]);

        $role3 = Role::create(['name' => 'Super-Admin']);

        $user1 = User::factory()->create();
        $user1->roles()->sync($role3);

        $user2 = User::factory()->create();
        $user2->roles()->sync($role2);

        $user3 = User::factory()->create();
        $user3->roles()->sync($role1);
    }
}
