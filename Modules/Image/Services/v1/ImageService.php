<?php

namespace Module\Image\Services\v1;

use Module\Image\Models\Image;
use Module\Image\Services\ImageService as Service;

class ImageService extends Service
{
    public function store($request)
    {
        $path = "uploads/post";

        foreach ($request->name as $key => $value) {
            $name = $request->image[$key]->hashName();
            $request->image[$key]->move(public_path($path), $name);

            Image::query()->create([
                'name' => $value,
                'image' => $name
            ]);
        }

        return;
    }
}