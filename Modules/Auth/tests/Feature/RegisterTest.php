<?php

namespace Module\Auth\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\CustomTestCase;

class RegisterTest extends CustomTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function register_a_user()
    {
        $this->CreateUser();

        $data = [
            'name' => 'test',
            'email' => 'test2@test.com',
            'phone' => "09121234567",
            'password' => 'password'
        ];
        $res = $this->post(route('register.v2'), $data)
            ->assertCreated();

        $this->assertArrayHasKey('status', $res);
    }

    /** @test */
    public function handle_length_name_when_register_user()
    {
        $this->CreateUser();

        $data = [
            'name' => 't',
            'email' => 'test@test.com',
            'phone' => "09121234567",
            'password' => 'password'
        ];

        $this->post(route('register.v2'), $data)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_string_name_when_register_user()
    {
        $this->CreateUser();

        $data = [
            'name' => 123,
            'email' => 'test@test.com',
            'phone' => "09121234567",
            'password' => 'password'
        ];

        $this->post(route('register.v2'), $data)
            ->assertStatus(422);
    }

    /** @test */
    public function unique_email_when_register_user()
    {
        $this->CreateUser();

        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'phone' => "09121234567",
            'password' => 'password'
        ];

        $data2 = [
            'name' => 'test2',
            'email' => 'test@test.com',
            'phone' => "09121234567",
            'password' => 'password'
        ];
        $this->post(route('register.v2'), $data);

        $this->post(route('register.v2'), $data2)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_length_password_when_register_user()
    {
        $this->CreateUser();

        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
            'phone' => "09121234567",
            'password' => 'pass'
        ];

        $this->post(route('register.v2'), $data)
            ->assertStatus(422);
    }
}
