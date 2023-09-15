<?php

namespace Module\Auth\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Module\Auth\Http\Requests\v2\LoginRequest;
use Module\Auth\Http\Requests\v2\RegisterRequest;
use Module\Auth\Services\v2\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Resources\v2\UserResource;

class AuthController extends Controller implements ResponseGenerator
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = resolve(AuthService::class);
    }

    /**
     * Register user
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $store = $this->service->store($request);

        return $this->res($store['status'], $store['code'], $store['message'], $store['data']);
    }

    /**
     * Login user
     *
     * @param  \Module\User\Http\Requests\v2\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse $this->response($status,$message,$data)
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $login = $this->service->login($request);

        return $this->res($login['status'], $login['code'], $login['message'], $login['data']);
    }

    public function res(string $status, int $code, string|null $message, array|int|ResourceCollection|JsonResource $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => ! $data ? null : [
                'user' => new UserResource($data['user']),
                'token' => $data['token'],
            ],
        ], $code);
    }
}
