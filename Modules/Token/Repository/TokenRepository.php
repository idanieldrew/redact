<?php

namespace Module\Token\Repository;

use Module\Share\Repository\Repository;
use Module\Token\Models\Token;

class TokenRepository extends Repository
{
    public function model()
    {
        return Token::query();
    }
}
