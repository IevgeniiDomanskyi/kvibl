<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UploadController extends Controller
{
    public function upload_image(Request $request)
    {
        $result = service('Api\Upload')->upload_image($request->get('base64'));
        return response()->result($result);
    }
}
