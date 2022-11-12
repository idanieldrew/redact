<?php

namespace Module\Token\Services\v1;

class Verify
{
    public function send(VerifyInterface $verify)
    {
        $verify->send();
    }
}
