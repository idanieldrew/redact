<?php

namespace Module\Panel\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Module\Panel\Jobs\CeremonyMessage;
use Module\Panel\Mail\CeremonyMail;
use Module\User\Models\User;
use Tests\TestCase;

class CeremonyMessageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function send_message_with_queue()
    {
        Bus::fake();
        Mail::fake();
        Bus::assertNotDispatched(CeremonyMessage::class);
        Mail::assertNothingSent();

        $this->CreateUser('admin');
        User::factory(5)->create();
        $this->post(route('ceremony.message'), ['body' => 'test content'])
            ->assertOk();

        Bus::assertDispatched(CeremonyMessage::class);
    }

    /** @test */
    public function send_mail()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $this->CreateUser('admin');
        User::factory(5)->create();
        $this->post(route('ceremony.message'), ['body' => 'test content'])
            ->assertOk();

        Mail::assertSent(CeremonyMail::class);
    }
}
