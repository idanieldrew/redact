<?php

namespace Module\Media\Services;

use Module\Image\Models\Image;
use Module\Media\Models\Media;
use Module\Share\Service\Service;

class MediaService implements Service
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return Media::query();
    }
}