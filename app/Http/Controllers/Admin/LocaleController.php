<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Locale\Item as LocaleItemResourse;

class LocaleController extends Controller
{
    public function all()
    {
        $result = service('Admin\Locale')->all();
        return response()->result(LocaleItemResourse::collection($result));
    }
}
