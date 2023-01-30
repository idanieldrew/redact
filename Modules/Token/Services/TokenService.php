<?php

namespace Module\Token\Services;

use Module\Share\Service\Service;
use Module\User\Models\Token;

class TokenService implements Service
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return Token::query();
    }
}
