<?php

namespace Module\Media\Contracts;

use Illuminate\Http\UploadedFile;

interface FileContract
{
    /**
     * Upload media
     * @param UploadedFile $file
     * @param $filename string
     * @param $dir string
     * @return array | string
     */
    public static function upload(UploadedFile $file, string $filename, string $dir);
}
