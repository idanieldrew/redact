<?php

namespace Module\User\Http\Controllers\auth\v1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function notice()
    {
        dd("first verify");
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('post.index');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        dd('ok');
    }
}