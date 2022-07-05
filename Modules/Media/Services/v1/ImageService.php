<?php

namespace Module\Media\Services\v1;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;
use Module\Media\Contracts\FileContract;
use Module\Media\Services\MediaService as Service;

class ImageService extends Service implements FileContract
{
    use DefaultService;

    private static $sizes = [300, 600];

    /**
     * Upload media
     * @param UploadedFile $file
     * @param $filename
     * @param $dir
     * @return array
     */
    public static function upload(UploadedFile $file, $filename, $dir): array
    {
        $extension = $file->getClientOriginalExtension();

        $path = $dir . $filename . '.' . $extension;

        Storage::putFileAs($dir, $file, $filename . '.' . $extension);

        return self::resize(Storage::path($path), $dir, $filename, $extension);
    }

    /**
     * Resize media with Intervention package
     * @param $img
     * @param $dir
     * @param $name
     * @param $extension
     * @return array
     */
    private static function resize($img, $dir, $name, $extension): array
    {
        $img = Intervention::make($img);

        $images['original'] = $name . '.' . $extension;

        foreach (self::$sizes as $size) {
            $images[$size] = $name . '_' . $size . '.' . $extension;
            $img->resize($size, null, function ($aspect) {
                $aspect->aspectRatio();
            })
                ->save(Storage::path($dir) . $name . '_' . $size . '.' . $extension);
        }
        return $images;
    }
}