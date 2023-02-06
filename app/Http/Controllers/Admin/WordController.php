<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Word\Item as WordItemResourse;
use App\Http\Requests\Admin\Word\All as WordAllRequest;
use App\Http\Requests\Admin\Word\Add as WordAddRequest;
use App\Http\Requests\Admin\Word\Delete as WordDeleteRequest;
use App\Http\Requests\Admin\Word\Update as WordUpdateRequest;
use App\Http\Requests\Admin\Word\Reset as WordResetRequest;

class WordController extends Controller
{
    public function all($category_id, $message = false)
    {
        $result = service('Admin\Word')->all($category_id);
        return response()->result(WordItemResourse::collection($result), $message);
    }

    public function add(WordAddRequest $request)
    {
        $data = $request->all();
        $word = service('Admin\Word')->add($data);
        $message = 'Слово успішно додане';
        return $this->all($data['category_id'], $message);
    }

    public function update(WordUpdateRequest $request)
    {
        $data = $request->only('id', 'value', 'is_active');
        $category_id = $request['category_id'];
        $result = service('Admin\Word')->update($data);
        $message = 'Слово успішно відредаговано';
        return $this->all($category_id, $message);
    }

    public function delete(WordDeleteRequest $request)
    {
        $data = $request->all();
        $word = service('Admin\Word')->delete($data['ids']);
        $message = count($data['ids']) == 1 ? 'Слово успішно видалене' : 'Слова успішно видалені';
        return $this->all($data['category_id'], $message);
    }

    public function reset($category_id)
    {
        $word = service('Admin\Word')->reset($category_id);
        $message = 'Лічильники успішно скинуті';
        return $this->all($category_id, $message);
    }
}
