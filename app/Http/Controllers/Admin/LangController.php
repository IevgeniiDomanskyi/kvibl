<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Lang\Item as LangItemResourse;

class LangController extends Controller
{
    public function all()
    {
        $result = service('Admin\Lang')->all();
        return response()->result(LangItemResourse::collection($result));
    }
}
