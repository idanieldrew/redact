<?php

namespace Module\User\Services\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Module\User\Http\Requests\v1\RegisterRequest;
use Module\User\Models\User;
use Module\User\Services\UserService as Service;

class UserService extends Service
{
    /**
     * Update $this->model
     * @param int $param
     * @param Request; $request
     * @return mixed
     */
    public function update(int $param, $request)
    {
        // Just user can edit our information
        if (Gate::denies('update', [User::class, $param])) {
            abort(403);
        }

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
     * @param RegisterRequest $request
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
            'success' => true,
            'status' => Response::HTTP_CREATED,
            'message' => 'Successfully registered',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
    }

    /**
     * try to log in
     * @param RegisterRequest $request
     * @return array
     */
    public function login(RegisterRequest $request): array
    {
        $user = $this->model()->whereEmail($request->email)->first();

        // Check exist user
        if (!$user || Hash::check($request->password, $user->password)) {
            return $this->response('fail', Response::HTTP_UNAUTHORIZED, 'invalid email or password');
        }

        $token = $user->createToken('token')->plainTextToken;
        return $this->response('success', Response::HTTP_OK, 'success login', [$user, $token]);
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
