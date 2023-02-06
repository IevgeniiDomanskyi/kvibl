<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\Add as CategoryAddRequest;
use App\Http\Requests\Admin\Category\Delete as CategoryDeleteRequest;
use App\Http\Resources\Admin\Category\Item as CategoryItemResourse;

class CategoryController extends Controller
{
    public function all($message = false)
    {
        $result = service('Admin\Category')->all();
        return response()->result(CategoryItemResourse::collection($result), $message);
    }
    
    public function get($id)
    {
        $result = service('Admin\Category')->get($id);
        return response()->result(new CategoryItemResourse($result));
    }
    
    public function add(CategoryAddRequest $request)
    {
        $data = $request->all();
        $category = service('Admin\Category')->add($data);
        $message = 'Категорія успішно додана';

        if ($category) {
            return $this->all($message);
        }
    }
    
    public function delete(CategoryDeleteRequest $request)
    {
        $data = $request->only('ids');
        service('Admin\Category')->delete($data['ids']);
        $message = count($data['ids']) == 1 ? 'Категорія успішно видалена' : 'Категорії успішно видалені';
        return $this->all($message);
    }

    public function uploadImportFile(Request $request)
    {
        return service('Admin\Category')->upload($request);
    }

    public function uploadCategoryImage(Request $request)
    {
        return service('Admin\Category')->uploadImage($request);
    }

    public function import(Request $request)
    {
        $data = $request->all();
        service('Admin\Category')->import($data[0]);
        $result = service('Admin\Category')->all();
        $message = 'Категорії успішно імпортовані';
        return $this->all($message);
    }

    public function export()
    {
        service('Admin\Category')->export();
    }
}
