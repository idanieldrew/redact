<?php

namespace Module\User\tests\Feature\CrudUser\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations, WithFaker, WithoutEvents;

    public function register()
    {
        $this->WithoutEvents();
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'phone' => "09121234567",
            'password' => 'password'
        ];

        $this->post(route('register.v2'), $data);
    }

    /** @test */
    public function login_a_user()
    {
        $this->register();

        $res = $this->post(route('login.v2'), [
            'email' => "test@test.com",
            'password' => "password",
            'phone' => "09121234567"
        ])->assertOk();

        $res->assertJsonFragment(['status' => "success"]);
    }

    /** @test */
    public function login_with_wrong_email()
    {
        $this->register();

        $this->post(route('login.v2'), [
            'email' => 'wrong@wrong.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    /** @test */
    public function login_with_wrong_password()
    {
        $this->register();

        $this->post(route('login.v2'), [
            'email' => 'test@test.com',
            'password' => 'wrong'
        ])->assertStatus(422);
    }
}
