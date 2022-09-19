<?php

namespace Module\User\tests\Feature\CrudUser\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Module\User\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function login_a_user()
    {
        $this->withoutExceptionHandling();
        $this->CreateUser();

        $res = $this->post(route('login.v2'), [
            'email' => "test@test.com",
            'password' => "password"
        ])->assertOk();

        $res->assertJsonFragment(['status' => "success"]);
    }

    /** @test */
    public function login_with_wrong_email()
    {
        $this->CreateUser();

        $this->post(route('login.v2'), [
            'email' => 'wrong@wrong.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    /** @test */
    public function login_with_wrong_password()
    {
        $this->CreateUser();

        $this->post(route('login.v2'), [
            'email' => 'test@test.com',
            'password' => 'wrong'
        ])->assertStatus(422);
    }
}
