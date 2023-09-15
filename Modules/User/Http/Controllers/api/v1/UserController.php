<?php

namespace Module\User\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\User\Http\Notifications\CeremonyMessage;
use Module\User\Http\Requests\v1\UpdateRequest;
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
     *
     * @throws AuthorizationException
     */
    public function index()
    {
        // Check permissions
        $this->authorize('viewAny', User::class);

        $users = $this->repo()->paginate();

        return $this->res('Success', Response::HTTP_OK, 'Show all users', $users);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return UserResource
     *
     * @throws AuthorizationException
     */
    public function show(User $user): UserResource
    {
        // Check permissions
        $this->authorize('view', [User::class, $user->username]);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $user
     * @param  UpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws AuthorizationException
     */
    public function update(string $user, UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        // Check permissions
        $this->authorize('update', [User::class, $user]);

        $this->service()->update($user, $request);

        return $this->res('Success', Response::HTTP_NO_CONTENT, 'Successfully update user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Module\User\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(User $user)
    {
        // Check permissions
        $this->authorize('delete', [User::class, $user]);

        $this->repo()->destroy($user);

        return $this->res('Success', Response::HTTP_OK, 'Successfully delete user');
    }

    public function res(string $status, int $code, string|null $message, array|int|JsonResource $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function sendSms()
    {
        auth()->user()->notify(new CeremonyMessage());

        Log::info('send it');
        dd(44);
    }
}
