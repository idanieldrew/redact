<?php

namespace Module\User\tests\Feature\CrudUser\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    public function register()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'phone' => "09121234567",
            'password' => 'password'
        ];

        $this->post(route('register.v2'),$data);
    }

    /** @test */
    public function login_a_user()
    {
        $this->register();

        $res = $this->post(route('login.v2'),[
            'email' => "test@test.com",
            'password' => "password",
            'phone' => "09121234567"
        ])->assertOk();

        $this->assertArrayHasKey('status',$res);
    }

    /** @test */
    public function login_with_wrong_email()
    {
        $this->withoutExceptionHandling();
        $this->register();

        $this->post(route('login.v2'),[
            'email' => 'wrong@wrong.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    /** @test */
    public function login_with_wrong_password()
    {
        $this->register();

        $this->post(route('login.v2'),[
            'email' => 'test@test.com',
            'password' => 'wrong'
        ])->assertStatus(422);
    }
}