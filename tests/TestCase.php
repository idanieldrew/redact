<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;
use Module\Role\Models\Permission;
use Module\Role\Models\Role;
use Module\User\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function CreateUser($type = 'writer'): array
    {
        // Create role
        $this->createRole();
        // Find it
        $role = Role::query()->where('name', $type)->firstOrFail();

        // Create new user with type admin
        $user = User::factory()->create();

        $user->assignRole($type);
        // actingAs
        Sanctum::actingAs($user);

        return [$user, $role->id];
    }

    private function createRole()
    {
        $role1 = Role::create(['name' => 'writer']);
        $role2 = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'super']);

        $p1 = Permission::create(['name' => 'view-users']);

        $role2->givePermissionTo($p1);
        $role3->givePermissionTo($p1);
    }
}
