<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Team\Item as TeamItemResourse;
use App\Team;
use App\Game;

class TeamController extends Controller
{
    public function get(Game $game)
    {
        $result = service('Api\Team')->get($game);
        return response()->result(TeamItemResourse::collection($result));
    }
}
