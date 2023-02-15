<?php

namespace Module\Auth\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Module\Auth\Notifications\ForgetPsdNotify;
use Module\User\Models\User;
use Tests\CustomTestCase;

class ForgetPsdTest extends CustomTestCase
{
    use RefreshDatabase;

    /** @test */
    public function wrong_email_forget_psd()
    {
        $this->CreateUser();
        $this->post(route('forget-password'), [
            'field' => 'dan@dan.com'
        ])->assertUnauthorized();
    }

    /** @test */
    public function success_operation()
    {
        $this->CreateUser();
        $this->post(route('forget-password'), [
            'field' => 'test@test.com'
        ])->assertOk();

        $this->assertDatabaseHas('tokens', [
            'type' => 'email verified'
        ]);
    }

    /** @test */
    public function mock_notify_for_forget_psd()
    {
        $this->CreateUser();
        $this->post(route('forget-password'), [
            'field' => 'test@test.com'
        ])->assertOk();

        Notification::fake();

        Notification::assertNotSentTo(
            User::where('email', 'test@test.com')->first(),
            ForgetPsdNotify::class
        );
    }
}
