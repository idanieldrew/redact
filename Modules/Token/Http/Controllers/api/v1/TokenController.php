<?php

namespace Module\Token\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Module\Token\Models\Token;
use Module\User\Services\v2\UserService;


class TokenController extends Controller
{
    public function otp()
    {
        $repo = resolve(UserService::class);
        return $repo->checkOtp();
        /*$token = Token::query()->create([
            'user_id' => $user->id
        ]);

        if ($token->send()) {
            return;
        }
        $token->delete();
        return;*/
    }
}
