<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Module\Auth\Services\v2\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;

class ForgetPsdController extends Controller implements ResponseGenerator
{
    protected function service():AuthService
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

    public function res(string $status, int $code, string|null $message, array|int|JsonResource $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
