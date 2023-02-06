<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Text\All as TextAllResourse;
use App\Locale;

class TextController extends Controller
{
    public function __construct()
    {
        //
    }

    public function get(Request $request, Locale $locale)
    {
        $text = service('Api\Text')->get($locale);
        return response()->result(new TextAllResourse($text));
    }

    public function all(Request $request)
    {
        $texts = service('Api\Text')->all();
        return response()->result(new TextAllResourse($texts));
    }
}
