<?php

namespace Module\Media\Services;

use Module\Media\Models\Media;
use Module\Share\Service\Service;

class MediaService implements Service
{
    public function model(): \Illuminate\Database\Eloquent\Builder
    {
        return Media::query();
    }
}
