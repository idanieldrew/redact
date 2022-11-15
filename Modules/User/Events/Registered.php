<?php

namespace Module\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Module\User\Models\User;

class Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function getUser()
    {
        return $this->user;
    }
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        protected User $user
    )
    {
    }
}
