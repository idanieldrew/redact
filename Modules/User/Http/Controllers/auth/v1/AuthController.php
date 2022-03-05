<?php

namespace Module\User\Http\Controllers\auth\v1;

use App\Http\Controllers\Controller;
use Module\User\Http\Requests\LoginRequest;
use Module\User\Http\Requests\RegisterRequest;
use Module\User\Http\Resources\v1\UserResource;
use Module\User\Services\UserService;

class AuthController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = resolve(UserService::class);
    }

    /*
    * Register user
    * @param \Module\User\Http\Requests\RegisterRequest $request
    * @return $this->response($status,$message,$data)
    */
    public function register(RegisterRequest $request)
    {
        $store = $this->service->store($request);

        return $this->response(201,'registered successfully',$store);
    }

    /*
    * Login user
    * @param \Module\User\Http\Requests\LoginRequest $request
    * @return $this->response($status,$message,$data)
    */
    public function login(LoginRequest$request)
    {
        $login = $this->service->login($request);

        return $this->response(201,'login successfully',$login);
    }

    private function response($status,$message,$data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'user' => new UserResource($data[0]),
                'token' => $data[1]
            ]
        ]);
    }
}