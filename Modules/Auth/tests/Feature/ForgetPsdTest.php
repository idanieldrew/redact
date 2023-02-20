<?php

namespace Module\Auth\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Module\Auth\Notifications\ForgetPsdNotify;
use Module\Token\Models\Token;
use Module\User\Models\User;
use Tests\CustomTestCase;

class ForgetPsdTest extends CustomTestCase
{
    use RefreshDatabase, WithFaker;

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

    /** @test */
    public function check_exist_incorrect_token()
    {
        $this->post(route('verify-forget-psd'), [
            'token' => 'abcde',
        ])->assertNotFound();
    }

    /** @test */
    public function check_exist_correct_token()
    {
        $this->CreateUser();
        $this->post(route('forget-password'), [
            'field' => 'test@test.com'
        ])->assertOk();
        $token = Token::first()->token;

        $this->post(route('verify-forget-psd'), [
            'token' => $token,
        ])->assertOk();
    }

    /** @test */
    public function check_exist_correct_token_with_incorrect_time()
    {
        $this->CreateUser();
        $this->post(route('forget-password'), [
            'field' => 'test@test.com'
        ])->assertOk();
        $token = Token::first()->token;

        // should a fewer 10 minute
        $this->travelTo(now()->addMinutes(11));
        $this->post(route('verify-forget-psd'), [
            'token' => $token,
        ])->assertNotFound();
    }
}
