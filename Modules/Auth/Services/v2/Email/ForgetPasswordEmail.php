<?php

namespace Module\Auth\Services\v2\Email;

use Module\Auth\Notifications\ForgetPsdNotify;
use Module\Auth\Services\v2\ForgetPasswordInterface;
use Module\User\Models\User;

class ForgetPasswordEmail implements ForgetPasswordInterface
{
    public function __construct(public User $user, protected string $token)
    {
    }

    public function send()
    {
        $this->user->notify(new ForgetPsdNotify($this->user->email, $this->token));
    }
}
