<?php

namespace Module\User\Services\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Module\User\Models\User;
use Module\User\Services\UserService as Service;

class UserService extends Service
{
    /**
   * Update $this->model
   * @param string $param
   * @param \Module\User\Http\Requests\v1\UserRequest; $request
   * @return \Module\User\Models\User
   */
    public function update($param,$request)
    {
        // Just user can edit our information
       if (Gate::denies('update',[User::class,$param])){
            abort(403);
        }

        return $this->model
            ->whereId($param)
            ->update($request->all());
    }

   /**
  *Create new user
  * @param \Module\User\Http\Requests\v1\RegisterRequest $request
  * @return array
  */
    public function store($request)
    {
        $user = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
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

    /*
    * try to login
    * @param \Module\User\Http\Requests\RegisterRequest $request
    * @return [\Module\User\Models\User,number]
    */
    public function login($request)
    {
        $user = User::whereEmail($request->email)->first();

        // Check exist user
        if (!$user || Hash::check($request->password,$user->password)){
            return [
                'success' => false,
                'status' => 401,
                'message' => 'invalid email or password',
                'data' => [
                    'user' => null,
                    'token' => null
                ]
            ];
        }

        $token = $user->createToken('token')->plainTextToken;

        return [
            'success' => true,
            'status' => 200,
            'message' => 'invalid email or password',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
    }
}