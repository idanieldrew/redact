<?php

namespace Module\Comment\Services;

use Module\Comment\Models\Comment;
use Module\Share\Service\Service;

class CommentService implements Service
{
    public function model()
    {
        return Comment::query();
    }
}
