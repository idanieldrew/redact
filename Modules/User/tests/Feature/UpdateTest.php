<?php

namespace Module\User\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Module\User\Models\User;
use Tests\CustomTestCase;

class UpdateTest extends CustomTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function super_can_update_user()
    {
        $this->CreateUser('super');
        $user = User::factory()->create();

        $this->patch(
            route('user.update', $user->username),
            ['email' => 'test@test.co'])
            ->assertNoContent();

        $this->assertDatabaseHas('users', ['email' => 'test@test.co']);
    }

    /** @test */
    public function user_can_not_update_other_user()
    {
        $this->CreateUser();
        $secondUser = User::factory()->create();

        $this->patch(
            route('user.update', $secondUser->username),
            ['email' => 'test@test.co'])
            ->assertStatus(403);
    }

    /** @test */
    public function user_can_update_own_information()
    {
        $res = $this->CreateUser();

        $this->patch(
            route('user.update', $res[0]->username),
            ['email' => 'test@test.co'])
            ->assertNoContent();

        $this->assertDatabaseHas('users', ['email' => 'test@test.co']);
    }

    /** @test */
    public function admin_can_not_update_user()
    {
        $this->CreateUser('admin');
        $user = User::factory()->create();

        $this->patch(
            route('user.update', $user->username),
            ['email' => 'test@test.co'])
            ->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'test@test.co']);
    }

    /** @test */
    public function admin_can_update_user_role()
    {
        $res = $this->CreateUser('admin');
        $user = User::factory()->create();

        $this->patch(
            route('user.update', $user->username),
            ['role' => 'admin'])
            ->assertNoContent();

        $this->assertDatabaseHas('users', [
            'role_id' => $res[1],
        ]);
    }

    /** @test */
    public function user_can_not_update_own_role()
    {
        $res = $this->CreateUser();

        $this->patch(
            route('user.update', $res[0]->username),
            ['role' => 'admin'])
            ->assertForbidden();
    }
}
