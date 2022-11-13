<?php

namespace Module\User\Http\Controllers\auth\v2;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Requests\v2\LoginRequest;
use Module\User\Http\Requests\v2\RegisterRequest;
use Module\User\Http\Resources\v2\UserResource;
use Module\User\Services\v2\UserService;

class AuthController extends Controller implements ResponseGenerator
{
    private $service;

    public function __construct()
    {
        $this->service = resolve(UserService::class);
    }

    /**
     * Register user
     * @param \Module\User\Http\Requests\v2\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $store = $this->service->store($request);

//        event(new Registered($store['data']['user']));

        return $this->res($store['status'], $store['code'], $store['message'], $store['data']);
    }

    /**
     * Login user
     * @param \Module\User\Http\Requests\v2\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse $this->response($status,$message,$data)
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $login = $this->service->login($request);

        return $this->res($login['status'], $login['code'], $login['message'], $login['data']);
    }

    public function res($status, $code, $message, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => !$data ? null : [
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ]
        ], $code);
    }
}
