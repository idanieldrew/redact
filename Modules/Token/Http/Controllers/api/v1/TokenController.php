<?php

namespace Module\Token\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Module\Share\Contracts\Response\ResponseGenerator;
use Module\Token\Repository\v1\TokenRepository;
use Module\Token\Services\v1\TokenService;

class TokenController
{
    // resolve Module\User\Repository\UserRepository
    public function repo()
    {
        return resolve(TokenRepository::class);
    }

    // resolve Module\User\Services\UserService
    public function service()
    {
        return resolve(TokenService::class);
    }
}