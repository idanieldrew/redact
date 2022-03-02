<?php

namespace Module\User\Services;

use Module\Share\Service\Service;
use Module\User\Models\User;

class UserService implements Service
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return User::query();
    }

    /*
   * Update $this->model
   * @param string $slug
   * @return \Module\User\Models\User
   */
    public function update($param,$request)
    {
        return $this->model->whereId($param)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
    }
}