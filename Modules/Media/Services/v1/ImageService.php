<?php

namespace Module\Media\Services\v1;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;
use Module\Media\Contracts\FileContract;
use Module\Media\Services\MediaService as Service;
use Str;

class ImageService extends Service implements FileContract
{
    use DefaultService;

    private static $sizes = [300, 600];

    /**
     * Upload media
     * @param UploadedFile $file
     * @param $filename string
     * @param $dir string
     * @param bool $resize
     * @return array | string
     */
    public static function upload(UploadedFile $file, string $filename, string $dir, bool $resize = true)
    {
        $extension = $file->getClientOriginalExtension();

        $filename = Str::slug($filename);
        $path = "$dir/$filename.$extension";

        Storage::putFileAs($dir, $file, $filename . '.' . $extension);

        return $resize ?
            self::resize(Storage::path($path), $dir, $filename, $extension) :
            $path;
    }

    /**
     * Resize media with Intervention package
     * @param $img string
     * @param $dir string
     * @param $name string
     * @param $extension string
     * @return array
     */
    private static function resize(string $img, string $dir, string $name, string $extension): array
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
