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
            'password' => 'password',
            'phone' => "09121234567"
        ];

        $this->post(route('register'),$data);
    }

    /** @test */
    public function login_a_user()
    {
        $this->withoutExceptionHandling();
        $this->register();

        $res = $this->post(route('login.v2'),[
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'phone' => $this->faker->phoneNumber
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