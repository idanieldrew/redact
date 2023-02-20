<?php

namespace Module\Token\Repository\v1;

use Module\Token\Repository\TokenRepository as Repository;

class TokenRepository extends Repository
{
    /**
     * Generate token row with user relation
     *
     * @param $user
     * @param $request
     * @return mixed
     */
    public function store($user, $request)
    {
        return $user->tokenz()->create([
            'token' => $request->token,
            'data' => json_encode([$request->data => $request->field]),
            'type' => "$request->data verified",
            'expired_at' => now()->addMinutes(10),
        ]);
    }

    /**
     * @param string $token
     * @return bool
     */
    public function existToken(string $token)
    {
        return $this->model()
            ->where('token', $token)
            ->where('expired_at', '>', now())
            ->exists();
    }
}
