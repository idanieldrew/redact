<?php

namespace Module\Token\Services\v1;

use Module\User\Models\User;

class SmsVerify implements VerifyInterface
{
    public function __construct(public User $user)
    {
    }

    public function send()
    {
        echo 'send sms';
    }
}
