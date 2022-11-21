<?php

namespace Module\User\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\CustomTestCase;

class ReadTest extends CustomTestCase
{
    use RefreshDatabase;

    /** @test */
    public function super_can_see_all_users()
    {
        $res = $this->CreateUser('super');

        $this->assertDatabaseHas('users', ['username' => $res[0]->username]);

        $this->get(route('user.index'))->assertSee($res[0]->email);
    }

    /** @test */
    public function admin_can_see_all_users()
    {
        $res = $this->CreateUser('admin');

        $this->assertDatabaseHas('users', ['username' => $res[0]->username]);

        $this->get(route('user.index'))->assertSee($res[0]->email);
    }

    /** @test */
    public function user_can_not_see_all_users()
    {
        $res = $this->CreateUser();
        User::factory()->create();

        $this->assertDatabaseHas('users', ['username' => $res[0]->username]);

        $this->get(route('user.index'))
            ->assertForbidden();
    }

    /** @test */
    public function super_can_see_one_user()
    {
        $this->CreateUser('super');
        $user = User::factory()->create();

        $this->get(route('user.show', $user->id))
            ->assertOk();
    }

    /** @test */
    public function admin_can_not_see_one_user()
    {
        $this->CreateUser('admin');
        $user = User::factory()->create();

        $this->get(route('user.show', $user->id))
            ->assertForbidden();
    }

    /** @test */
    public function user_can_see_our_information()
    {
        $this->CreateUser('admin', 'email@email.com');

        $user = User::whereEmail('email@email.com')->first(['id']);

        $this->get(route('user.show', $user->id))
            ->assertOk();
    }
}
