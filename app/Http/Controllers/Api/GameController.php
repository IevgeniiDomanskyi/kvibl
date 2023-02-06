<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Game\Connect as GameConnectRequest;
use App\Http\Requests\Api\Game\Start as GameStartRequest;
use App\Http\Resources\Api\Game\Item as GameItemResourse;
use App\Http\Resources\Api\Player\Item as PlayerItemResourse;
use App\Game;
use App\Player;

class GameController extends Controller
{
    public function get(Game $game)
    {
        $result = service('Api\Game')->get($game->id);
        return response()->result(new GameItemResourse($result));
    }

    public function create()
    {
        $result = service('Api\Game')->create();
        return response()->result(new GameItemResourse($result));
    }

    public function connect(GameConnectRequest $request)
    {
        $code = $request->get('code');
        $result = service('Api\Game')->connect($code);
        return response()->result(new GameItemResourse($result));
    }

    public function last()
    {
        $result = service('Api\Game')->last();
        return response()->result(new GameItemResourse($result));
    }

    public function start(GameStartRequest $request, Game $game)
    {
        $settings = $request->only('teams', 'sorted_teams', 'categories');
        $result = service('Api\Game')->start($game, $settings);
        return response()->result(new GameItemResourse($result));
    }

    public function forget(Game $game)
    {
        $result = service('Api\Game')->forget($game->id);
        return response()->result(true);
    }

    public function remove(Game $game)
    {
        $result = service('Api\Game')->remove($game->id);
        return response()->result(true);
    }

    public function me(Game $game)
    {
        $result = service('Api\Game')->me($game);
        return response()->result(new PlayerItemResourse($result));
    }
}
