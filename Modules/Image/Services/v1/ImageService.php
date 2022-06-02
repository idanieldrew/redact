<?php

namespace Module\Image\Services\v1;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;
use Module\Image\Services\ImageService as Service;

class ImageService extends Service
{
    use DefaultService;

    private $sizes = [300, 600];

    public function upload(UploadedFile $file, $name, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $path = $dir . $name . '.' . $extension();

        Storage::putFileAs($dir, $file, $name . '.' . $extension);

        return $this->resize(Storage::path($path), $dir, $name, $extension);
    }

    private function resize($img, $dir, $name, $extension)
    {
        $img = Intervention::make($img);

        $images['original'] = $name . '.' . $extension;

        foreach ($this->sizes as $size) {
            $images[$size] = $name . '_' . $size . '.' . $extension;
            $img->resize($size, null, function ($aspect) {
                $aspect->aspectRatio();
            })
                ->save(Storage::path($dir) . $name . '_' . $size . '.' . $extension);
        }
        return $images;
    }

    /* public function store($request)
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
    } */
}