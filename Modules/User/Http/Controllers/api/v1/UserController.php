<?php

namespace Module\User\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\User\Http\Resources\v1\UserCollection;
use Module\User\Http\Resources\v1\UserResource;
use Module\User\Models\User;
use Module\User\Repository\UserRepository;

class UserController extends Controller
{

    protected $repo;

    public function __construct()
    {
        $this->repo = resolve(UserRepository::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserCollection($this->repo->paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user
     * @return object
     */
    public function show($user)
    {
        $user = $this->repo->show($user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Module\User\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

    }
}