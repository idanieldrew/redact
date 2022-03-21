<?php

namespace Module\User\tests\Feature\CrudUser\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function register_a_user()
    {
        $data = [
          'name' => 'test',
          'email' => 'test@test.com',
          'password' => 'password'
        ];
        $res = $this->post(route('register'),$data)
            ->assertOk();

        $this->assertArrayHasKey('token',$res);
    }

    /** @test */
    public function handle_length_name()
    {
        $data = [
            'name' => 'na',
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        $this->post(route('register'),$data)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function handle_string_name()
    {
        $data = [
            'name' => 1234,
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        $this->post(route('register'),$data)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function unique_email_when_register_user()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        $data2 = [
            'name' => 'test2',
            'email' => 'test@test.com',
            'password' => 'password'
        ];
        $this->post(route('register'),$data);

        $this->post(route('register'),$data2)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function handle_length_password()
    {
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => '123'
        ];

        $this->post(route('register'),$data)
            ->assertSessionHasErrors();
    }
}