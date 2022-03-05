<?php

namespace Module\User\Http\Controllers\auth\v1;

use App\Http\Controllers\Controller;
use Module\User\Http\Requests\RegisterRequest;
use Module\User\Models\User;
use Module\User\Services\UserService;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $service = resolve(UserService::class);

        $store = $service->store($request);

        return response()->json([
            'status' => 'success',
            'message' => 'registered successfully',
            'data' => $store
        ],200);
    }
}