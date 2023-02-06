<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Category\Item as CategoryItemResourse;
use App\Category;
use App\User;
use App\Lang;

class CategoryController extends Controller
{
    public function all()
    {
        $result = service('Api\Category')->allActive();
        return response()->result(CategoryItemResourse::collection($result));
    }

    public function get(Category $category)
    {
        return response()->result(new CategoryItemResourse($category));
    }

    public function assign(Category $category, Lang $lang)
    {
        $result = service('Api\Category')->assign($category, $lang);
        return response()->result(new CategoryItemResourse($category));
    }
}
