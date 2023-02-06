<?php

namespace App\Services\Api;

use App\Services\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\User;

class UploadService extends Service
{

    public function __construct()
    {
    }

    public function upload_image($base64_image)
    {
        $pos = strpos($base64_image, ',');
        $pos = $pos !== false ? ($pos + 1) : 0;
        $data = substr($base64_image, $pos);
        $data = base64_decode($data);
        $path = "avatars/".Str::random(10).".png";


        if (Storage::put($path, $data)) {
            return Storage::url($path);
        }

        return false;
    }
}
