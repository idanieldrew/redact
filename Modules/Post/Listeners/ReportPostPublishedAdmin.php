<?php

namespace Module\Post\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Module\Post\Events\PostPublish;
use Module\Post\Mail\PostPublishedPermission;
use Module\User\Repository\v1\UserRepository;

class ReportPostPublishedAdmin implements ShouldQueue
{

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */

    /**
     * Handle the event.
     *
     * @param PostPublish $event
     * @return void
     */
    public function handle(PostPublish $event)
    {
        $repo = resolve(UserRepository::class);

        $mail = new PostPublishedPermission($event->getPost());

        // Send mail
        foreach ($repo->admins() as $user) {
            Mail::to($user->email)->send($mail);
        }
    }
}
