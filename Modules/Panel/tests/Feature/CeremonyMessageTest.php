<?php

namespace Module\Panel\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Module\User\Models\User;
use Tests\TestCase;

class CeremonyMessageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function send_message()
    {
        $this->withoutExceptionHandling();
        $this->CreateUser();
        User::factory(10)->create();
        $this->get(route('ceremony.message'));
    }
}
