<?php

namespace Module\User\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Requests\UserRequest;
use Module\User\Http\Resources\v1\UserCollection;
use Module\User\Http\Resources\v1\UserResource;
use Module\User\Models\User;
use Module\User\Repository\UserRepository;
use Module\User\Services\UserService;

class UserController extends Controller implements ResponseGenerator
{
    // resolve \ Module\User\Repository\UserRepository
    public function repo()
    {
        return resolve(UserRepository::class);
    }

    // resolve \Module\User\Services\UserService
    public function service()
    {
        return resolve(UserService::class);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Module\User\Http\Resources\v1\UserCollection
     */
    public function index()
    {
        $users = $this->repo()->paginate(10);

        return new UserCollection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user
     * @return \Module\User\Http\Resources\v1\UserResource
     */
    public function show($user)
    {
        $user = $this->repo()->show($user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $user
     * @param  \Module\User\Http\Requests\UserRequest  $request
     * @return \Module\User\Http\Resources\v1\UserResource
     */
    public function update($user,UserRequest $request)
    {
        $this->service()->update($user,$request);

        return $this->res(true,Response::HTTP_NO_CONTENT,'Successfully update user',null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Module\User\Models\User $user
     * @return \Module\User\Http\Resources\v1\UserResource
     */
    public function destroy(User $user)
    {
        $this->repo()->destroy($user);

        return $this->res(true,Response::HTTP_OK,'Successfully delete user',null);
    }

    public function res($success, $status, $message, $data)
    {
        return response()->json([
            'success' => $success,
            'message' => $status,
            'data' => $data
        ],$status);
    }
}