<?php

namespace Module\Post\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Module\Post\Events\PostPublish;
use Module\User\Repository\UserRepository;

class SendNotificationAdmin implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
      public $queue = 'admin';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
      public $delay = 90;

    /**
     * Handle the event.
     *
     * @param  PostPublish  $event
     * @return void
     */
    public function handle(PostPublish $event)
    {
        $repo = resolve(UserRepository::class);

        foreach ($repo->admins() as $user){
            dd(2,$user->email);
        }
    }
}