<?php

namespace Module\User\Http\Controllers\auth\v2;

use App\Http\Controllers\Controller;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Services\UserService;

class AuthController extends Controller implements ResponseGenerator
{
    private $service;

    public function __construct()
    {
        $this->service = resolve(UserService::class);
    }

    /**
     * Register user
     * @param \Module\User\Http\Requests\RegisterRequest $request
     * @return $this->response($status,$message,$data)
     */
    public function register(RegisterRequest $request)
    {
        $store = $this->service->store($request);

        event(new Registered($store['data']['user']));

        return $this->res($store['success'],$store['status'],$store['message'],$store['data']);
    }

    /**
     * Login user
     * @param \Module\User\Http\Requests\LoginRequest $request
     * @return $this->response($status,$message,$data)
     */
    public function login(LoginRequest$request)
    {
        $login = $this->service->login($request);

        return $this->res($login['success'],$login['status'],$login['message'],$login['data']);
    }

    // manage response
    public function res($success, $status, $message, $data)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'user' => $data['user'] ? new UserResource($data['user']) : null,
            'token' => $data['token']
        ],$status);    }
}