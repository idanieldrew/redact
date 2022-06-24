<?php

namespace Module\Media\Contracts;

use Illuminate\Http\UploadedFile;

interface FileContract
{
    public static function upload(UploadedFile $file, string $filename, string $dir);
}