<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Player\Item as PlayerItemResourse;
use App\Http\Resources\Api\Word\Item as WordItemResourse;
use App\Player;
use App\Game;
use App\Word;

class WordController extends Controller
{
    public function get(Game $game, Player $player)
    {
        $result = service('Api\Word')->get($game, $player);
        return response()->result(WordItemResourse::collection($result));
    }

    public function view(Game $game, Player $player, Word $word)
    {
        $result = service('Api\Word')->view($game, $player, $word);
        return response()->result(new WordItemResourse($result));
    }

    public function approve(Game $game, Player $player, Word $word)
    {
        $result = service('Api\Word')->approve($game, $player, $word);
        return response()->result(new WordItemResourse($result));
    }

    public function confirm(Game $game, Player $player, Word $word, $is_confirm)
    {
        $result = service('Api\Word')->confirm($game, $player, $word, $is_confirm);
        return response()->result($result);
    }
}
