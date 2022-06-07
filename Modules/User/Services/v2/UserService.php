<?php

namespace Module\User\Services\v2;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Module\Token\Models\Token;
use Module\User\Models\User;
use Module\User\Services\UserService as Service;

class UserService extends Service
{
    /**
     *Create new user
     * @param \Module\User\Http\Requests\v2\RegisterRequest $request
     * @return array
     */
    public function store($request)
    {
        $user = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->email)
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
     * @param \Module\User\Http\Requests\v2\RegisterRequest $request
     * @return null
     */
    public function login($request)
    {
        $user = User::whereEmail($request->email)->first();

        // Check exist user
        if (!$user || Hash::check($request->password, $user->password)) {
            return [
                'status' => 'fail',
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'invalid email or password',
                'data' => [
                    'user' => null,
                    'token' => null
                ]
            ];
        }

        $token = $user->createToken('test')->plainTextToken;

        return [
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'message' => 'Successfully login',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
    }
}