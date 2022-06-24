<?php

namespace Module\Media\Services\v1;

use Illuminate\Http\UploadedFile;
use Module\Media\Contracts\FileContract;
use Module\Media\Models\Media;

class MediaService
{
    private static $file;
    private static $dir;
    private static $isPrivate;

    public static function privateUpload(UploadedFile $file)
    {
        self::$file = $file;
        self::$dir = "private/";
        self::$isPrivate = true;
        return self::upload();
    }

    public static function publicUpload(UploadedFile $file)
    {
        self::$file = $file;
        self::$dir = 'public/';
        self::$isPrivate = false;
        return self::upload();
    }

    private static function upload()
    {
        $extension = self::normalizeExtension(self::$file);
        foreach (config('media.media.types') as $type => $service) {
            if (in_array($extension, $service['extensions'])) {
                return self::uploadByHandler(new $service['handler'], $type);
            }
        }
    }

    private static function normalizeExtension($file): string
    {
        return strtolower($file->getClientOriginalExtension());
    }

    private static function filenameGenerator(): string
    {
        return uniqid();
    }

    private static function uploadByHandler(FileContract $service, $key)
    {
        $media = new Media();

        $media->files = $service::upload(self::$file, self::filenameGenerator(), self::$dir);
        $media->type = $key;
        $media->user_id = auth()->id();
        $media->name = self::$file->getClientOriginalName();
        $media->isPrivate = self::$isPrivate;

        return $media;
    }
}
