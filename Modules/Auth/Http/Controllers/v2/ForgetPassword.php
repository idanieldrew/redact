<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Auth\Services\v2\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\Token\Models\Token;
use Module\User\Models\User;

class ForgetPassword extends Controller implements ResponseGenerator
{
    protected function service()
    {
        return resolve(AuthService::class);
    }

    /**
     * Handle forget password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPassword(Request $request)
    {
        $res = $this->service()->forgetPassword($request->field);

        return $this->res($res['status'], $res['code'], $res['message']);
    }

    /**
     * Handle verify forget password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyForgetPsd(Request $request)
    {
        $res = Token::query()->where('token', $request->token)->where('expired_at', '>', now())->exists();
        return $res ?
            $this->res('success', '200', 'correct') :
            $this->res('fail', '404', 'incorrect');
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
