<?php

namespace Module\User\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Module\Share\Service\Service;
use Module\User\Models\User;

class UserService implements Service
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return User::query();
    }

    /*
   * Update $this->model
   * @param string $slug
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

   /*
  *Create new user
  * @param \Module\User\Http\Requests\RegisterRequest $request
  * @return [\Module\User\Models\User,number]
  */
    public function store($request)
    {
        $user = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->email)
        ]);
        $token = $user->createToken('token')->plainTextToken;

        event(new Registered($user));

        return [$user,$token];
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
            return response()->json([
                'status' => false,
                'message' => 'invalid email or password'
            ],401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return [$user, $token];
    }
}