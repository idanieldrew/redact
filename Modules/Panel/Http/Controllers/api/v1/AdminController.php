<?php

namespace Module\Panel\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Module\Panel\Jobs\CeremonyMessage;

class AdminController extends Controller
{
    /**
     *
     */
    public function ceremony()
    {
        CeremonyMessage::dispatch();
    }
}
