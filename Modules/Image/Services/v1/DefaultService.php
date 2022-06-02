<?php

namespace Module\Image\Services\v1;

use Illuminate\Support\Facades\Storage;

trait DefaultService
{
    public function delete($image)
    {
        foreach ($image->image as $img) {
            if ($image->isPrivate) {
                Storage::delete('private//' . $img);
            } else {
                Storage::delete('public//' . $img);
            }
        }
    }
}