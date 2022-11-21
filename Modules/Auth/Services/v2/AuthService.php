<?php

namespace Module\Auth\Services\v2;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Module\User\Models\User;
use Module\Auth\Services\AuthService as Service;

class AuthService extends Service
{
    /**
     *Create new user
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        $user = $this->model()->create([
            'username' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return [
            'status' => 'success',
            'code' => Response::HTTP_CREATED,
            'message' => 'Successfully registered',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
    }

    /**
     * try to login
     * @param $request
     * @return null
     */
    public function login($request): array
    {
        $user = User::whereEmail($request->email)->first();

        // Check exist user
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->response(
                'error',
                Response::HTTP_UNAUTHORIZED,
                'invalid email or password',
                null
            );
        }

        $token = $user->createToken('test')->plainTextToken;

        return $this->response(
            'success',
            Response::HTTP_OK,
            'Successfully login',
            ['user' => $user, 'token' => $token]
        );
    }

    /**
     * Return array
     * @param string $status
     * @param int $code
     * @param string $message
     * @param $data
     * @return array
     */
    private function response(string $status, int $code, string $message, $data): array
    {
        return [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data ?: null
        ];
    }
}
