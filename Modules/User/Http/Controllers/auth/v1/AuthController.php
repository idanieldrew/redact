<?php

namespace Module\User\Http\Controllers\auth\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Requests\v1\LoginRequest;
use Module\User\Http\Requests\v1\RegisterRequest;
use Module\User\Services\v1\UserService;

class AuthController extends Controller implements ResponseGenerator
{
    private $service;

    public function __construct()
    {
        $this->service = resolve(UserService::class);
    }

    /**
     * Register user
     * @param \Module\User\Http\Requests\v1\RegisterRequest $request
     * @return $this->response($status,$message,$data)
     */
    public function register(RegisterRequest $request)
    {
        $res = $this->service->store($request);

        event(new Registered($store['data']['user']));

        return $this->res('Success', Response::HTTP_OK, 'Successfully register', [$res[0], $res[1]]);
    }

    /**
     * Login user
     * @param \Module\User\Http\Requests\v1\LoginRequest $request
     * @return $this->response($status,$message,$data)
     */
    public function login(LoginRequest $request)
    {
        $login = $this->service->login($request);

        return $this->res('success', Response::HTTP_OK, 'Successfully login', [$login[0], $login[1]]);
    }

    public function res($status, $code, $message, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'user' => $data['user'] ?? null,
                'token' => $data['token']
            ]
        ], $code);
    }
}
