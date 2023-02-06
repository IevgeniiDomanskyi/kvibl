<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\ActionRepository;
use App\Player;
use App\Action;

class ActionService extends Service
{
    protected $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    //Get all player actions
    public function get(Player $player)
    {
        return $player->actions;
    }

    //Add action for player
    public function add(Player $player, $data)
    {
        return $this->actionRepository->add($player, $data);
    }

    //Remove action from player
    public function remove(Action $action)
    {
        $this->actionRepository->remove($action->id);
    }
}