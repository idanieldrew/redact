<?php

namespace Module\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $p1 = Permission::create(['name' => 'edit-post']);
        $p2 = Permission::create(['name' => 'delete-post']);
        $p3 = Permission::create(['name' => 'publish-post']);
        $p4 = Permission::create(['name' => 'unpublished-post']);
        $p5 = Permission::create(['name' => 'create-post']);
        // user
        $p6 = Permission::create(['name' => 'delete user']);
        $p7 = Permission::create(['name' => 'view-users']);
        // category
        $p8 = Permission::create(['name' => 'create-category']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo($p4, $p5);

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo($p1, $p2, $p3, $p5, $p7, $p8);

        $role3 = Role::create(['name' => 'super']);
        $role3->givePermissionTo($p1, $p2, $p3, $p5, $p6, $p7, $p8);

        $role3->users()->create([
            'name' => 'super',
            'email' => 'super@super.com',
            'password' => Hash::make('password'),
            'phone' => '09121234567'
        ]);

        /*$super = User::factory(['name' => 'super'])->create();
        $super->assignRole($role3->name);*/
    }
}
