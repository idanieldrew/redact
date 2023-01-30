<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Auth\Services\v2\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;

class ForgetPassword extends Controller implements ResponseGenerator
{
    protected function service()
    {
        return resolve(AuthService::class);
    }

    /**
     * Handle forget password
     *
     * @param  Request  $request
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
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyForgetPsd(Request $request)
    {
        $res = $this->service()->verfyToken($request->token);

        return $this->res($res['status'], $res['code'], $res['message']);
    }

    public function res($status, $code, $message, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
