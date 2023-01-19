<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Module\Auth\Mail\ForgetPassword as ForgetPasswordAlias;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Models\User;

class ForgetPassword extends Controller implements ResponseGenerator
{
    public function ForgetPassword(Request $request)
    {
        $data = filter_var($request->field, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::query()->where($data, $request->field)->first();
        if (!$user) {
            return $this->res('fail', Response::HTTP_UNAUTHORIZED, 'email not found');
        }

        $token = Str::random(5);
        $user->tokenz()->create([
            'token' => $token,
            'data' => json_encode([$data => $request->field]),
            'type' => "$data verified",
            'expired_at' => now()->addMinutes(10)
        ]);

        Mail::to($request->field)->send(mailable: new ForgetPasswordAlias($request->field, $token));
        return 4;
    }

    public function res($status, $code, $message, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
