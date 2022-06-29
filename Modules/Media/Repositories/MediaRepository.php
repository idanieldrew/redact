<?php

namespace Module\Media\Repositories;

use Module\Media\Models\Media;

class MediaRepository
{
    public function model(): string
    {
        return Media::class;
    }
}
