<?php

namespace App\Repositories;

use App\Player;
use App\Game;

class PlayerRepository
{
    public function find($id)
    {
        return Player::find($id);
    }

    public function update(Player $player, array $data)
    {
        $player->fill($data);
        $player->save();
        return $player;
    }

    public function remove($id)
    {
        $player = Player::find($id);
        $player->delete();
    }

    public function randomPlayer(Game $game, Player $player)
    {
        return $game->players()->where('id', '<>', $player->id)->inRandomOrder()->first();
    }

    public function getByHash($hash)
    {
        return Player::where('hash', $hash)->first();
    }

    public function getByName(Game $game, $name)
    {
        return $game->players()->whereRaw('UPPER(name) = "'.strtoupper($name).'"')->first();
    }

    public function setFinished(Game $game, Player $player)
    {
        $player->confirms()->newPivotStatement()->where('player_id', '=', $player->id)->where('game_id', '=', $game->id)->update(array('is_finished' => true));
        return $player;
    }
}
