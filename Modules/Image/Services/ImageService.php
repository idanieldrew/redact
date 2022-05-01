<?php

namespace Module\Image\Services;

use Module\Image\Models\Image;
use Module\Share\Service\Service;

class ImageService implements Service
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return Image::query();
    }
}