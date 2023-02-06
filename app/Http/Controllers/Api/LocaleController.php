<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Locale\Item as LocaleItemResourse;
use App\Locale;

class LocaleController extends Controller
{
    public function __construct()
    {
        //
    }

    public function all(Request $request)
    {
        $locales = service('Api\Locale')->all();
        return response()->result(LocaleItemResourse::collection($locales));
    }

    public function get(Request $request, Locale $locale)
    {
        $locale = service('Api\Locale')->get($locale->id);
        return response()->result(new LocaleItemResourse($locale));
    }

    public function set(Request $request, Locale $locale)
    {
        $locale = service('Api\Locale')->set($locale->id);
        return response()->result(new LocaleItemResourse($locale));
    }
}
