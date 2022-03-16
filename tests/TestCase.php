<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Module\User\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function CreateUser($type = 'user')
    {
        // Create new user with type admin
        $user = User::factory()->create(['type' => $type]);

        // actingAs
        $this->actingAs($user);

        return $user;
    }
}