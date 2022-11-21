<?php

namespace Module\Auth\Services\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Module\Auth\Services\AuthService as Service;

class AuthService extends Service
{
    /**
     * Update $this->model
     * @param int $param
     * @param Request; $request
     * @return mixed
     */
    public function update(int $param, $request)
    {
        if ($request->only('role')) {
            $user = $this->model()->findOrFail($param);
            $user->assignRole($request->role);
            return;
        }

        return $this->model()
            ->whereId($param)
            ->update($request->validated());
    }

    /**
     *Create new user
     * @param $request
     * @return array
     */
    public function store($request)
    {
        $user = $this->model()->create([
            'username' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('token')->plainTextToken;
        return [
            'token' => $token,
            'user' => $user
        ];
    }

    /**
     * try to log in
     * @param $request
     * @return array
     */
    public function login($request): array
    {
        $user = $this->model()->whereEmail($request->email)->first();

        // Check exist user
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->response('fail', Response::HTTP_UNAUTHORIZED, 'invalid email or password');
        }

        $token = $user->createToken('token')->plainTextToken;
        return $this->response('success', Response::HTTP_OK, 'Successfully login', ['user' => $user, 'token' => $token]
        );
    }

    /**
     * Return array
     * @param string $status
     * @param int $code
     * @param string $message
     * @param null $data
     * @return array
     */
    private function response(string $status, int $code, string $message, $data = null): array
    {
        return [
            $status,
            $code,
            $message,
            $data
        ];
    }
}
