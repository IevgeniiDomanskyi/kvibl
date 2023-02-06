<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\VirusRepository;
use App\Events\Api\Game\PlayersChange as PlayersChangeEvent;
use App\Events\Api\Virus\VirusRandom as VirusRandomEvent;
use App\Player;
use App\Game;
use App\Virus;

class VirusService extends Service
{
    protected $virusRepository;

    public function __construct(VirusRepository $virusRepository)
    {
        $this->virusRepository = $virusRepository;
    }
    
    //get list of all viruses
    public function all()
    {
        return $this->virusRepository->all();
    }

    //get player viruses inside bag
    public function get(Game $game, Player $player)
    {
        return $player->viruses_bag;
    }

    //generate random virus for player
    public function random(Game $game, Player $player, $position)
    {
        $virus = $this->virusRepository->random();

        $count = 1;
        $existing_virus = $player->viruses_bag()->find($virus->id);
        if ($existing_virus) {
            $count = $existing_virus->pivot->count+1;
        }

        $player->viruses_bag()->detach($virus);
        $player->viruses_bag()->attach($virus, ['count' => $count]);

        service('Api\Action')->add($player, ['action' => 'virus-'.$game->lap]);

        event(new VirusRandomEvent($game, $virus, $position));
        event(new PlayersChangeEvent($game));
        
        return $virus;
    }

    //put virus to another player
    public function apply(Game $game, Player $player, Virus $virus, $id)
    {
        $virus = $player->viruses_bag()->find($virus->id);
        if (!$virus) {
            return response()->message('game.message.user_dont_have_virus', 'error', 422);
        }

        $applyPlayer = service('Api\Player')->find($id);

        if (!$applyPlayer) {
            return response()->message('game.message.empty_apply_virus_target', 'error', 422);
        }

        $player->viruses_bag()->detach($virus);
        if ($virus->pivot->count > 1)
        {
            $player->viruses_bag()->attach($virus, ['count' => $virus->pivot->count - 1]);
        }

        $applyPlayer->viruses()->attach($virus, ['owner_id' => $player->id]);
        
        event(new PlayersChangeEvent($game));

        return $player->viruses;
    }
}
