<?php

namespace Module\Auth\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\CustomTestCase;

class ChangePsdTest extends CustomTestCase
{
    use RefreshDatabase;

    /** @test */
    public function old_password_not_match()
    {
        $this->CreateUser();

        $this->post(route('chang-psd'), [
            'old_password' => 'wrongpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ])->assertStatus(400);
    }

    /** @test */
    public function password_confirmation_not_match()
    {
        $this->CreateUser();

        $this->post(route('chang-psd'), [
            'old_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword2'
        ])->assertStatus(422);
    }

    /** @test */
    public function correct_operation()
    {
        $password = 'newpassword';
        $this->CreateUser();

        $this->post(route('chang-psd'), [
            'old_password' => 'password',
            'password' => $password,
            'password_confirmation' => $password
        ])->assertStatus(200);

        $cond = Hash::check($password, auth()->user()->password);
        $this->assertTrue($cond);
    }
}
