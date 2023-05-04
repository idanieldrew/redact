<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Tests\CustomTestCase;

uses(CustomTestCase::class, RefreshDatabase::class);

it('correctVerify', function () {
    list($user, ,) = $this->CreateUser();
    $url = URL::temporarySignedRoute('verify.v2',
        now()->addMinutes(15),
        ['user' => $user->id]
    );
    Http::fake([
        route('register.v2') => Http::response(
            $url
        )
    ]);

    $this->get($url)->assertOk();
});

it('inCorrectVerify', function () {
    list($user, ,) = $this->CreateUser();
    $url = URL::temporarySignedRoute('verify.v2',
        now()->addMinutes(15),
        ['user' => $user->id]
    );
    Http::fake([
        route('register.v2') => Http::response(
            $url
        )
    ]);

    $this->travel(2)->hours();

    $this->get($url)->assertForbidden();
});
