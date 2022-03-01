<?php

namespace Module\User\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Module\User\Http\Resources\v1\UserCollection;
use Module\User\Models\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return
     */
    public function index()
    {
        $users = User::all();

        return new UserCollection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Module\User\Models\User $post
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }
}