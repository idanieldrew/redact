<?php

namespace Module\Auth\Services\v2\Phone;

use Illuminate\Support\Facades\Log;
use Module\Auth\Services\v2\ForgetPasswordInterface;

class ForgetPasswordPhone implements ForgetPasswordInterface
{
    public function send()
    {
        Log::info('coming soon!');
    }
}
