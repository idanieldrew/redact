<?php

namespace Module\User\Http\Controllers\auth\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
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

        event(new Registered($store['data']['user']));

        return $this->response($store['success'],$store['status'],$store['message'],$store['data']);
    }

    /*
    * Login user
    * @param \Module\User\Http\Requests\LoginRequest $request
    * @return $this->response($status,$message,$data)
    */
    public function login(LoginRequest$request)
    {
        $login = $this->service->login($request);

        return $this->response($login['success'],$login['status'],$login['message'],$login['data']);
    }

    private function response($success,$status,$message,$data)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'user' => $data['user'] ? new UserResource($data['user']) : null,
            'token' => $data['token']
        ],$status);
    }
}