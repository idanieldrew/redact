<?php

namespace Module\User\tests\Feature\Ceremony;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\User\Models\User;
use Tests\TestCase;

class CeremonyMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ceremony_message()
    {
        $this->withoutExceptionHandling();
        $this->CreateUser();
        User::factory(5)->create();
        $this->post(route('ceremony'));
        dd(1112);
    }
}
