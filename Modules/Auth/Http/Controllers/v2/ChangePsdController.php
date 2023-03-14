<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Module\Auth\Http\Requests\v2\ChangePsdRequest;
use Module\Auth\Services\v2\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;

class ChangePsdController extends Controller implements ResponseGenerator
{
    /**
     * Change password operation
     *
     * @param ChangePsdRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changPsd(ChangePsdRequest $request)
    {
        $result = (new AuthService)->changePsd($request);

        return $this->res($result['status'], $result['code'], $result['message'], $result['data']);
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