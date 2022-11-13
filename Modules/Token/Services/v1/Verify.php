<?php

namespace Module\Token\Services\v1;

class Verify
{
    public function verify(VerifyInterface $verify)
    {
        $verify->send();
    }
}
