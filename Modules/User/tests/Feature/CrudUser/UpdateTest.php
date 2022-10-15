<?php

namespace Module\User\tests\Feature\CrudUser;

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
            route('user.update', $user->id),
            ['email' => 'test@test.co'])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => 'test@test.co']);
    }

    /** @test */
    public function user_can_not_update_other_user()
    {
        $firstUser = $this->CreateUser();
        $secondUser = User::factory()->create();

        $this->patch(
            route('user.update', $secondUser->id),
            ['email' => 'test@test.co'])
            ->assertStatus(403);
    }

    /** @test */
    public function user_can_update_own_information()
    {
        $res = $this->CreateUser();

        $this->patch(
            route('user.update', $res[0]->id),
            ['email' => 'test@test.co'])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => 'test@test.co']);
    }

    /** @test */
    public function admin_can_not_update_user()
    {
        $this->CreateUser('admin');
        $user = User::factory()->create();

        $this->patch(
            route('user.update', $user->id),
            ['email' => 'test@test.co'])
            ->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'test@test.co']);
    }

    /** @test */
    public function admin_can_update_user_role()
    {
        $this->withoutExceptionHandling();
        $res = $this->CreateUser('admin');
        $user = User::factory()->create();

        $this->patch(
            route('user.update', $user->id),
            ['role' => 'admin'])
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'role_id' => $res[1]
        ]);
    }

    /** @test */
    public function user_can_not_update_own_role()
    {
        $res = $this->CreateUser();

        $this->patch(
            route('user.update', $res[0]->id),
            ['role' => 'admin'])
            ->assertForbidden();
    }
}
