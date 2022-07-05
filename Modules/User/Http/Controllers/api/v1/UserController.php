<?php

namespace Module\User\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Notifications\CeremonyMessage;
use Module\User\Http\Requests\v1\UserRequest;
use Module\User\Http\Resources\v1\UserCollection;
use Module\User\Http\Resources\v1\UserResource;
use Module\User\Models\User;
use Module\User\Repository\v1\UserRepository;
use Module\User\Services\v1\UserService;

class UserController extends Controller implements ResponseGenerator
{
    // resolve Module\User\Repository\UserRepository
    public function repo()
    {
        return resolve(UserRepository::class);
    }

    // resolve Module\User\Services\UserService
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
        $users = $this->repo()->take(User::query(), User::class);

        return new UserCollection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        $user = $this->repo()->show($user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $user
     * @param \Module\User\Http\Requests\v1\UserRequest $request
     * @return UserResource
     */
    public function update($user, UserRequest $request)
    {
        $this->service()->update($user, $request);

        return $this->res('success', Response::HTTP_OK, 'Successfully update user', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Module\User\Models\User $user
     * @return UserResource
     */
    public function destroy(User $user)
    {
        $this->repo()->destroy($user);

        return $this->res('success', Response::HTTP_OK, 'Successfully delete user', null);
    }

    public function res($status, $code, $message, $data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function sendSms()
    {
        auth()->user()->notify(new CeremonyMessage());

        Log::info("send it");
    }
}
