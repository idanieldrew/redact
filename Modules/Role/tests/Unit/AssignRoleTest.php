<?php

namespace Module\Role\tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Module\Role\Models\Permission;
use Module\Role\Models\Role;
use Module\User\Models\User;
use Tests\CustomTestCase;

class AssignRoleTest extends CustomTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function assign_role_to_users()
    {
        $role = Role::create(['name' => 'writer']);
        $user = User::factory()->create();

        $user->assignRole($role->name);

        $this->assertTrue($role->users->contains($user));
        $this->assertEquals(1, $role->users->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $role->users);
    }

    /** @test */
    public function relation_roles_and_permissions()
    {
        $role = Role::create(['name' => 'writer']);
        $permission = Permission::create(['name' => 'create-post']);
        $role->givePermissionTo($permission);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $role->permissions);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $permission->role_permissions);
    }
}
