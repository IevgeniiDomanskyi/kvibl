<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\User\Item as UserItemResourse;
use App\Http\Requests\Admin\User\All as UserAllRequest;
//use App\Http\Requests\Admin\User\Add as UserAddRequest;
//use App\Http\Requests\Admin\User\Delete as UserDeleteRequest;
//use App\Http\Requests\Admin\User\Update as UserUpdateRequest;

class UsersController extends Controller
{
    public function all()
    {
        $result = service('Admin\User')->all();
        return response()->result(UserItemResourse::collection($result));
    }

    public function add(WordAddRequest $request)
    {
        //NEED TO DO
        $data = $request->all();
        $word = service('Admin\User')->add($data);
        $message = 'Слово успішно додане';
        return $this->all($data['category_id'], $message);
    }

    public function update(WordUpdateRequest $request)
    {
        //NEED TO DO
        $data = $request->only('id', 'value', 'is_active');
        $category_id = $request['category_id'];
        $result = service('Admin\User')->update($data);
        $message = 'Слово успішно відредаговано';
        return $this->all($category_id, $message);
    }

    public function delete(WordDeleteRequest $request)
    {
        //NEED TO DO
        $data = $request->all();
        $word = service('Admin\User')->delete($data['ids']);
        $message = count($data['ids']) == 1 ? 'Слово успішно видалене' : 'Слова успішно видалені';
        return $this->all($data['category_id'], $message);
    }
}
