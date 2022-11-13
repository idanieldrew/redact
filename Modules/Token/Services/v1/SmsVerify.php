<?php

namespace Module\Token\Services\v1;

use Module\User\Models\User;

class SmsVerify implements VerifyInterface
{
    public function send(User $user)
    {
        echo 'send sms';
    }
}
