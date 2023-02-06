<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\TeamRepository;
use App\Player;
use App\Game;
use App\Team;

class TeamService extends Service
{
    protected $teamRepository;

    public function __construct(teamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function get(Game $game)
    {
        return $game->teams;
    }

    public function createRandom(Game $game, $names, $data)
    {
        $team = $this->teamRepository->create();

        $color = service('Api\Color')->randomColor($game->teams()->pluck('color_id')->toArray());
        $data['name'] = service('Api\Faker')->getName($names);
        $data['color_id'] = $color->id;
        $data['game_id'] = $game->id;

        $team = $this->teamRepository->update($team, $data);

        return $team;
    }

    public function setCurrentPlayer(Team $team, Player $player)
    {
        return $this->teamRepository->update($team, ['current_player_id' => $player->id]);
    }

    public function setNextPlayer(Team $team)
    {
        $set_position = $team->currentPlayer()->position  + 1;
        $next_player = $team->players()->where('position', $set_position)->first();
        if (!$next_player) {
            $next_player = $team->players()->where('position', 1)->first();
        }

        if ($next_player) {
            return $this->teamRepository->update($team, ['current_player_id' => $next_player->id]);
        }

        return $next_player;
    }

    public function update(Team $team, $data)
    {
        return $this->teamRepository->update($team, $data);
    }
}
