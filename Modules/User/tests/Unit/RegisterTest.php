<?php

namespace Module\User\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_check_correct_format_email_when_register_user()
    {
        $this->CreateUser();
        $user = User::factory()->create();
        $this->assertMatchesRegularExpression('/^.+\@\S+\.\S+$/', $user->email);
    }
}
