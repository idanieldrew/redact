<?php

namespace Module\Auth\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Module\Auth\Http\Requests\v1\LoginRequest;
use Module\Auth\Http\Requests\v1\RegisterRequest;
use Module\Auth\Services\v1\AuthService;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Resources\v1\UserResource;

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
     * @param  RegisterRequest  $request
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
     *
     * @param  LoginRequest  $request
     * @return JsonResponse $this->response($status,$message,$data)
     */
    public function login(LoginRequest $request)
    {
        $res = $this->service->login($request);

        return $this->res($res[0], $res[1], $res[2], $res[3]);
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
