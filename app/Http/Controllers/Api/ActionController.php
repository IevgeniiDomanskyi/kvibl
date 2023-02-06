<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Action\Item as ActionItemResourse;
use App\Http\Requests\Api\Action\Add as ActionAddRequest;
use App\Player;
use App\Action;

class ActionController extends Controller
{
    public function get(Player $player)
    {
        $result = service('Api\Action')->get($player);
        return response()->result(ActionItemResourse::collection($result));
    }

    public function add(ActionAddRequest $request, Player $player)
    {
        $data = $request->only('action', 'value');
        $result = service('Api\Action')->add($player, $data);
        return response()->result(new ActionItemResourse($result));
    }

    public function remove(Action $action)
    {
        $result = service('Api\Action')->remove($action);
        return response()->result($result);
    }
}
