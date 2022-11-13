<?php

namespace Module\Token\Services\v1;

use Module\User\Events\Registered;
use Module\User\Models\User;

class EmailVerify implements VerifyInterface
{
    public function __construct(public User $user)
    {
    }

    public function send()
    {
        Registered::dispatch($this->user);
//        ProcessMailVerify::dispatch($this->user->email);
    }
}
