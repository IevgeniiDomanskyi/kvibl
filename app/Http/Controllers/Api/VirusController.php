<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Player\Item as PlayerItemResourse;
use App\Http\Resources\Api\Virus\Item as VirusItemResourse;
use App\Http\Requests\Api\Virus\Apply as VirusApplyRequest;
use App\Player;
use App\Game;
use App\Virus;

class VirusController extends Controller
{
    public function all()
    {
        $result = service('Api\Virus')->all();
        return response()->result(VirusItemResourse::collection($result));
    }

    public function get(Game $game, Player $player)
    {
        $result = service('Api\Virus')->get($game, $player);
        return response()->result(VirusItemResourse::collection($result));
    }

    public function random(Game $game, Player $player, $position)
    {
        $result = service('Api\Virus')->random($game, $player, $position);
        return response()->result(new VirusItemResourse($result));
    }

    public function apply(VirusApplyRequest $request, Game $game, Player $player, Virus $virus)
    {
        $data = $request->only('id');
        $result = service('Api\Virus')->apply($game, $player, $virus, $data['id']);
        return response()->result(VirusItemResourse::collection($result));
    }
}
