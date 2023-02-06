<?php

namespace App\Repositories;

use App\Player;
use App\Action;

class ActionRepository
{
    public function add(Player $player, array $data)
    {
        return Action::create(['player_id' => $player->id,
                                'action' => !empty($data['action']) ? $data['action'] : '',
                                'value' => !empty($data['value']) ? $data['value'] : '']);
    }

    public function remove($id)
    {
        $action = Action::find($id);
        $action->delete();
    }
}
