<?php

namespace Module\User\Services\v1;

use Illuminate\Http\Request;
use Module\User\Services\UserService as Service;

class UserService extends Service
{
    /**
     * Update $this->model
     * @param int $param
     * @param Request; $request
     * @return mixed
     */
    public function update(int $param, $request)
    {
        if ($request->only('role')) {
            $user = $this->model()->findOrFail($param);
            $user->assignRole($request->role);
            return;
        }

        return $this->model()
            ->whereId($param)
            ->update($request->validated());
    }

    /**
     * Return array
     * @param string $status
     * @param int $code
     * @param string $message
     * @param null $data
     * @return array
     */
    private function response(string $status, int $code, string $message, $data = null): array
    {
        return [
            $status,
            $code,
            $message,
            $data
        ];
    }
}
