<?php

namespace Module\Token\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Module\Token\Mail\MailVerify;
use Module\User\Events\Registered;

class SendMailVerification implements ShouldQueue
{
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 15;

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $id = $event->getUser()->id;
        $mail = $event->getUser()->email;
        $name = $event->getUser()->username;

        Mail::to($mail)->send(new MailVerify($id, $mail, $name));
    }
}
