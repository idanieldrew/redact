<?php

namespace Module\User\tests\Feature\CrudUser\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithoutEvents;

    /** @test */
    public function register_a_user()
    {
        $this->WithoutEvents();
        $data = [
            'name' => 'test',
            'email' => 'test@test.com',
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
