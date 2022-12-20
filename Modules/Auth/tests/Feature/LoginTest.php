<?php

namespace Module\Auth\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CustomTestCase;

class LoginTest extends CustomTestCase
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
