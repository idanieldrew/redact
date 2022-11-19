<?php

namespace Module\Media\Services\v1;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Module\Media\Contracts\FileContract;
use Module\Media\Services\MediaService as Service;

class VideoService extends Service implements FileContract
{
    public static function upload(UploadedFile $file, string $filename, string $dir)
    {
        $extension = $file->getClientOriginalExtension();

        $filename = Str::slug($filename);

        Storage::putFileAs("$dir/video", $file, $filename . '.' . $extension);
        return "$dir/video/$filename.$extension";

    }
}
