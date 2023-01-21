<?php

namespace Module\Auth\Services\v2;

class ForgetPassword
{
    public function forgetPassword(ForgetPasswordInterface $forgetPassword): void
    {
        $forgetPassword->send();
    }
}
