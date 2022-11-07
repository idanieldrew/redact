<?php

namespace Module\User\Http\Controllers\auth\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Requests\v1\LoginRequest;
use Module\User\Http\Requests\v1\RegisterRequest;
use Module\User\Http\Resources\v1\UserResource;
use Module\User\Services\v1\UserService;

class AuthController extends Controller implements ResponseGenerator
{
    private UserService $service;

    public function __construct()
    {
        $this->service = resolve(UserService::class);
    }

    /**
     * Register user
     * @param RegisterRequest $request
     * @return JsonResponse $this->response($status,$message,$data)
     */
    public function register(RegisterRequest $request)
    {
        $res = $this->service->store($request);

        // verification by mail
        event(new Registered($res['user']));

        return $this->res('success', Response::HTTP_CREATED, 'Successfully register', $res);
    }

    /**
     * Login user
     * @param LoginRequest $request
     * @return JsonResponse $this->response($status,$message,$data)
     */
    public function login(LoginRequest $request)
    {
        $res = $this->service->login($request);

        return $this->res($res[0], $res[1], $res[2], $res[3]);
    }

    public function res($status, $code, $message, $data = null): JsonResponse
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
