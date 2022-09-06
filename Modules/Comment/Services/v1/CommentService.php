<?php

namespace Module\Comment\Services\v1;

use Module\Comment\Models\Comment;
use Module\Comment\Services\CommentService as Service;

class CommentService extends Service
{
    /**
     * Create comment
     */
    public function store($model,$request)
    {
        return $model->comments()->create([
            'body' => $request
        ]);
    }
}
