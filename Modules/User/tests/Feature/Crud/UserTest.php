<?php

namespace Module\User\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function super_can_see_users()
    {
        $user = $this->CreateUser('super');

        // Verified email
        $this->assertNotNull($user->email_verified_at);

        $this->assertDatabaseHas('users',['name' => $user->name]);

        $this->get(route('user.index'))->assertSee($user->email);
    }

    /** @test */
    public function admin_can_see_users()
    {
        $user = $this->CreateUser('admin');
        // Verify email
        $this->assertNotNull($user->email_verified_at);

        $this->assertDatabaseHas('users',['name' => $user->name]);

        $this->get(route('user.index'))->assertSee($user->email);
    }

    /** @test */
    public function user_can_not_see_users()
    {
        $user = $this->CreateUser();

        // Verify email
        $this->assertNotNull($user->email_verified_at);

        $this->assertDatabaseHas('users',['name' => $user->name]);

        $this->get(route('user.index'))->assertForbidden();
    }
}