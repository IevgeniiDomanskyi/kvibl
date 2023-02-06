<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Player\Item as PlayerItemResourse;
use App\Http\Requests\Api\Player\Update as PlayerUpdateRequest;
use App\Http\Requests\Api\Player\Add as PlayerAddRequest;
use App\Http\Requests\Api\Player\Tab as PlayerTabRequest;
use App\Http\Requests\Api\Player\Online as PlayerOnlineRequest;
use App\Player;
use App\Game;

class PlayerController extends Controller
{
    public function get(Game $game)
    {
        $result = service('Api\Player')->get($game);
        return response()->result(PlayerItemResourse::collection($result));
    }

    public function update(PlayerUpdateRequest $request, Game $game, Player $player)
    {
        $data = $request->only('name', 'status', 'avatar');
        $result = service('Api\Player')->updateName($player, $data);
        return response()->result(new PlayerItemResourse($result));
    }

    public function tab(PlayerTabRequest $request, Game $game, Player $player)
    {
        $data = $request->only('tab');
        $result = service('Api\Player')->updateTab($player, $data);
        return response()->result(new PlayerItemResourse($result));
    }

    public function finish(Game $game, Player $player)
    {
        $result = service('Api\Player')->finish($game, $player);
        return response()->result(new PlayerItemResourse($result));
    }

    public function confirm(Game $game, Player $player)
    {
        $result = service('Api\Player')->confirm($game, $player);
        return response()->result(new PlayerItemResourse($result));
    }

    public function awards(Game $game, Player $player)
    {
        $result = service('Api\Player')->awards($game, $player);
        return response()->result(new PlayerItemResourse($result));
    }

    public function prepare(Game $game, Player $player)
    {
        $result = service('Api\Player')->prepare($game, $player);
        return response()->result(new PlayerItemResourse($result));
    }

    public function online(PlayerOnlineRequest $request, Game $game, Player $player)
    {
        $data = $request->get('online');
        $result = service('Api\Player')->online($player, $request->get('online'));
        return response()->result(new PlayerItemResourse($result));
    }

    public function leave(PlayerOnlineRequest $request, Game $game, Player $player)
    {
        $result = service('Api\Player')->leave($game, $player);
        return response()->result($result);
    }

    public function remove(PlayerOnlineRequest $request, Game $game, Player $player, Player $removingPlayer)
    {
        $result = service('Api\Player')->remove($game, $player, $removingPlayer);
        return response()->result($result, 'game.message.player_successfully_removed');
    }

    public function add(PlayerAddRequest $request, Game $game, Player $player, Player $addingPlayer)
    {
        $team_id = $request->get('team_id');
        $result = service('Api\Player')->add($game, $player, $addingPlayer, $team_id);
        return response()->result($result, 'game.message.player_successfully_added');
    }

    public function push(Game $game, Player $player)
    {
        $result = service('Api\Player')->push($game, $player);
        return response()->result(new PlayerItemResourse($player));
    }
}
