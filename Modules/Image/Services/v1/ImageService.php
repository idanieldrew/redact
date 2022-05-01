<?php

namespace Module\Image\Services\v1;

use Module\Image\Models\Image;
use Module\Post\Services\ImageService as Service;

class ImageService extends Service
{
    public function store($request)
    {
        $path = "uploads/post";

        foreach ($request->name as $key => $value) {
            $name = $request->images[$key]->hashName();
            $request->images[$key]->move(public_path($path), $name);

            Image::query()->create([
                'name' => $value,
                'address' => $name
            ]);
        }

        return;
    }
}