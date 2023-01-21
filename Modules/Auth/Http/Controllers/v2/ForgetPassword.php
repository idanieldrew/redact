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

    public function ForgetPassword(Request $request)
    {
        $this->service()->forgetPassword($request->field);

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
