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

        // post
        $p1 = Permission::create(['name' => 'edit post']);
        $p2 = Permission::create(['name' => 'delete post']);
        $p3 = Permission::create(['name' => 'publish post']);
        $p4 = Permission::create(['name' => 'unpublished post']);
        $p6 = Permission::create(['name' => 'create-post']);

        // user
        $p5 = Permission::create(['name' => 'delete user']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);

        $role1->permissions()->attach([$p6->id]);

        $role2 = Role::create(['name' => 'admin']);
        $role2->permissions()->sync([$p3->id, $p4->id]);

        $role3 = Role::create(['name' => 'Super-Admin']);
        $role3->givePermissionTo($p5);

        $super = User::factory(['name' => 'super'])->create();
        $super->assignRole($role3->name);
    }
}
