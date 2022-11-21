<?php

namespace Module\User\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\CustomTestCase;

class DestroyTest extends CustomTestCase
{
    use RefreshDatabase;

    /** @test */
    public function super_can_destroy_user()
    {
        $this->withoutExceptionHandling();
        $this->CreateUser('super');
        $user = User::factory()->create();

        $this->delete(
            route('user.destroy', $user->id))
            ->assertOk();

//        $this->assertDatabaseMissing('users',['email' => $user->email]);
        $this->assertSoftDeleted('users', ['email' => $user->email]);
    }

    /** @test */
    public function user_can_not_destroy_other_user()
    {
        $this->CreateUser();
        $secondUser = User::factory()->create();

        $this->delete(
            route('user.destroy', $secondUser->id))
            ->assertForbidden();
    }

    /** @test */
    public function user_can_destroy_own_information()
    {
        $res = $this->CreateUser();

        $this->delete(
            route('user.destroy', $res[0]->id))
            ->assertOk();

        $this->assertSoftDeleted('users', ['email' => $res[0]->email]);
    }
}
