<?php

namespace Module\Auth\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\CustomTestCase;

class RegisterTest extends CustomTestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_check_correct_format_email_when_register_user(): void
    {
        $this->CreateUser();
        $user = User::factory()->create();
        $this->assertMatchesRegularExpression('/^.+\@\S+\.\S+$/', $user->email);
    }
}
