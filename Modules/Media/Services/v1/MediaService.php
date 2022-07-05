<?php

namespace Module\Media\Services\v1;

use Illuminate\Http\UploadedFile;
use Module\Media\Contracts\FileContract;
use Module\Media\Models\Media;

class MediaService
{
    private static $file;
    private static  $dir;
    private static $isPrivate;

    /**
     * Private upload
     * @param UploadedFile $file
     * @return Media|void
     */
    public static function privateUpload(UploadedFile $file)
    {
        self::$file = $file;
        self::$dir = "private/";
        self::$isPrivate = true;
        return self::upload();
    }

    /**
     * Public upload
     * @param UploadedFile $file
     * @return Media|void
     */
    public static function publicUpload(UploadedFile $file)
    {
        self::$file = $file;
        self::$dir = 'public/';
        self::$isPrivate = false;
        return self::upload();
    }

    /**
     * Upload
     * @return Media|void
     */
    private static function upload()
    {
        $extension = self::normalizeExtension(self::$file);
        foreach (config('media.media.types') as $type => $service) {
            if (in_array($extension, $service['extensions'])) {
                return self::uploadByHandler(new $service['handler'](), $type);
            }
        }
    }

    /**
     * To lower extension
     * @param UploadedFile $file
     * @return string
     */
    private static function normalizeExtension(UploadedFile $file): string
    {
        return strtolower($file->getClientOriginalExtension());
    }

    /**
     * To lower extension
     * @return string
     */
    private static function filenameGenerator(): string
    {
        return uniqid();
    }

    /**
     * To lower extension
     * @param FileContract $service
     * @param string $key
     * @return Media
     */
    private static function uploadByHandler(FileContract $service, string $key): Media
    {
        $media = new Media();

        // Upload images & zip & others
        // Image:  \Module\Media\Services\v1\ImageService::upload
        $media->files = $service::upload(self::$file, self::filenameGenerator(), self::$dir);
        $media->type = $key;
        $media->user_id = auth()->id();
        $media->name = self::$file->getClientOriginalName();
        $media->isPrivate = self::$isPrivate;

        return $media;
    }
}
