<?php

namespace App\Untils;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Upload
{
    public static function base64Image($param, $folder = "/")
    {
        if (str_contains($param, "base64")) {
            list($extension, $content) = explode(';', $param);
            $tmpExtension = explode('/', $extension);
            preg_match('/.([0-9]+) /', microtime(), $m);
            $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
            $content = explode(',', $content)[1];
            $storage = Storage::disk('uploads');

            $checkDirectory = $storage->exists($folder);

            if (!$checkDirectory) {
                $storage->makeDirectory($folder);
            }

            $storage->put($folder . '/' . $fileName, base64_decode($content), 'public');

            return url("uploads/$fileName");
        }
        return $param;
    }
}
