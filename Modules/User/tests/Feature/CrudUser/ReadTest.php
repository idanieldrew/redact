<?php

namespace Module\User\tests\Feature\CrudUser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\TestCase;

class ReadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function super_can_see_all_users()
    {
        $res = $this->CreateUser('super');

        // Verified email
        $this->assertNotNull($res[0]->email_verified_at);

        $this->assertDatabaseHas('users', ['name' => $res[0]->name]);

        $this->get(route('user.index'))->assertSee($res[0]->email);
    }

    /** @test */
    public function admin_can_see_all_users()
    {
        $res = $this->CreateUser('admin');
        // Verify email
        $this->assertNotNull($res[0]->email_verified_at);

        $this->assertDatabaseHas('users', ['name' => $res[0]->name]);

        $this->get(route('user.index'))->assertSee($res[0]->email);
    }

    /** @test */
    public function user_can_not_see_all_users()
    {
        $res = $this->CreateUser();
        User::factory()->create();

        $this->assertDatabaseHas('users', ['name' => $res[0]->name]);

        $this->get(route('user.index'))
            ->assertForbidden();
    }
}
