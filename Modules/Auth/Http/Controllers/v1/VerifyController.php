<?php

namespace Module\Auth\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    /**
     * @param  EmailVerificationRequest  $request
     * @return string
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return 'ok,verify it';
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function send(Request $request)
    {
        return null;
        /*$request->user()->sendEmailVerificationNotification();

        return 'send it';*/
    }
}
