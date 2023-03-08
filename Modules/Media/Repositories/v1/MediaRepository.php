<?php

namespace Module\Media\Repositories\v1;

use Illuminate\Database\Eloquent\Model;
use Module\Media\Models\Media;
use Module\Media\Repositories\MediaRepository as Repository;

class MediaRepository extends Repository
{
    /**
     * @param Model $model
     * @param Media $media
     * @return mixed
     */
    public function store(Model $model, Media $media): mixed
    {
        return $model->media()->create([
            'files' => $media->files,
            'type' => $media->type,
            'name' => $media->name,
            'isPrivate' => $media->isPrivate,
            'user_id' => $media->user_id,
        ]);
    }
}
