<?php

namespace Module\User\tests\Feature\CrudUser\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function register()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        $this->post(route('register'),$data);
    }

    /** @test */
    public function login_a_user()
    {
        $this->register();

        $res = $this->post(route('login'),[
            'email' => 'test@test.com',
            'password' => 'password'
        ])->assertOk();

        $this->assertArrayHasKey('token',$res);
    }

    /** @test */
    public function login_with_wrong_email()
    {
        $this->register();

        $this->post(route('login'),[
            'email' => 'wrong@wrong.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    /** @test */
    public function login_with_wrong_password()
    {
        $this->register();

        $this->post(route('login'),[
            'email' => 'test@test.com',
            'password' => 'wrong'
        ])->assertStatus(422);
    }
}