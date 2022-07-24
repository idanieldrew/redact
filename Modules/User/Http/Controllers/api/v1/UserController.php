<?php

namespace Module\User\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Notifications\CeremonyMessage;
use Module\User\Http\Requests\v1\UpdateRequest;
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
    public function index(): UserCollection
    {
        $users = $this->repo()->paginate(10);

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
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $user, UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->service()->update($user, $request);

        return $this->res('success', Response::HTTP_OK, 'Successfully update user');
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

    public function res($status, $code, $message, $data = null)
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
