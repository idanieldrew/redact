<?php

namespace Module\User\tests\Feature\CrudUser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function super_can_destroy_user()
    {
        $this->CreateUser('super');
        $user = User::factory()->create();

        $this->delete(
            route('user.destroy',$user->id))
            ->assertOk();

//        $this->assertDatabaseMissing('users',['email' => $user->email]);
        $this->assertSoftDeleted('users',['email' => $user->email]);
    }

    /** @test */
    public function user_can_not_destroy_other_user()
    {
        $this->CreateUser('user');
        $secondUser = User::factory()->create();

        $this->delete(
            route('user.destroy',$secondUser->id))
            ->assertForbidden();
    }

    /** @test */
    public function user_can_destroy_own_information()
    {
        $user = $this->CreateUser('user');

        $this->delete(
            route('user.destroy',$user->id))
            ->assertOk();

        $this->assertSoftDeleted('users',['email' => $user->email]);
    }
}