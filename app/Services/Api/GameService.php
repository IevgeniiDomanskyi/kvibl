<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\GameRepository;
use App\Events\Api\Game\PlayersChange as PlayersChangeEvent;
use App\Events\Api\Game\GameChange as GameChangeEvent;
use App\Events\Api\Game\GameRemove as GameRemoveEvent;
use App\Game;
use App\Player;

class GameService extends Service
{
    protected $gameRepository;

    public function __construct(gameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    //Get game info by id
    public function get($id) {
        $me = auth()->user();
        $game = $this->gameRepository->get($id);

        if ( ! $game->users()->where('user_id', $me->id)->exists()) {
            return response()->message('game.message.user_not_in_game', 'error', 422);
        }

        service('Api\Player')->online($game->players()->where('user_id', $me->id)->first(), true);

        return $game;
    }

    //Create game
    public function create()
    {
        $me = auth()->user();

        $game = $this->gameRepository->create();

        $data['hash'] = $this->_hash($game->id.$game->created_at.$me->id);
        $data['code'] = $this->_generateCode();

        $game = $this->gameRepository->update($game, $data);

        $playerHash = service('Api\Player')->hash($game->id.$me->created_at.$me->email);

        $this->gameRepository->attach($game, $me, ['is_owner' => true, 'hash' => $playerHash, 'tab' => 0]);
        $game->load('players');

        return $game;
    }

    //Connet to game with code
    public function connect($code)
    {
        $me = auth()->user();

        $game = $this->gameRepository->getByCode($code);

        if (empty($game)) {
            return response()->message('game.message.not_found', 'error', 422);
        }

        if ($game->complete) {
            return response()->message('game.message.game_completed', 'error', 422);
        }

        $playerHash = service('Api\Player')->hash($game->id.$me->created_at.$me->email);
        $color = service('Api\Color')->randomColor($game->players()->pluck('color_id')->toArray());

        $this->gameRepository->attach($game, $me, ['hash' => $playerHash, 'color_id' => $color->id, 'tab' => 0]);
        $game->load('players');

        service('Api\Player')->online($game->players()->where('user_id', $me->id)->first(), true);
        event(new PlayersChangeEvent($game));

        return $game;
    }

    //Update game info
    public function update(Game $game, $data)
    {
        $game = $this->gameRepository->update($game, $data);

        event(new GameChangeEvent($game));

        return $game;
    }

    //Get last user game
    public function last()
    {
        $me = auth()->user();

        $game = $this->gameRepository->last($me);
        if ($game) {
            $game->load('players');
        }

        return $game;
    }

    //Start game
    public function start(Game $game, $settings)
    {
        $me = auth()->user();
        $player = $game->players()->where('user_id', $me->id)->first();
        if (empty($player) || !$player->is_owner) {
            return response()->message('game.message.player_not_owner', 'error', 422);
        }

        if (empty($settings['teams']) && empty($settings['sorted_teams'])) {
            return response()->message('game.message.not_anought_players', 'error', 422);
        }

        if (!empty($settings['teams'])) {
            if ((count($game->players->where('status', Player::STATUS_PLAYER)) / $settings['teams']) < 2) {
                return response()->message('game.message.not_anought_players', 'error', 422);
            }
        }

        if (!empty($settings['sorted_teams'])) {
            foreach ($settings['sorted_teams'] as $sorted_team) {
                if (count($sorted_team) < 2) {
                    return response()->message('game.message.not_anought_players', 'error', 422);
                }
            }
        }


        if (!empty($settings['sorted_teams'])) {
            if ($current_team_id = $this->derebanSorted($game, $settings)) {
                $game = $this->gameRepository->update($game, ['current_team_id' => $current_team_id, 'status' => Game::STATUS_MAIN]);
            }
        } else {
            if ($current_team_id = $this->dereban($game, $settings)) {
                $game = $this->gameRepository->update($game, ['current_team_id' => $current_team_id, 'status' => Game::STATUS_MAIN]);
            }
        }

        event(new GameChangeEvent($game));

        return $game;
    }

    //Clear old player game
    public function clear()
    {
        $this->gameRepository->clear();
    }


    public function forget($id)
    {
        $me = auth()->user();
        $this->gameRepository->forget($me, $id);
    }

    //Remove game
    public function remove($id)
    {
        event(new GameRemoveEvent($this->gameRepository->get($id)));
        $this->gameRepository->remove($id);
    }

    //return me player by game
    public function me(Game $game)
    {
        $me = auth()->user();
        return $game->players()->where('user_id', $me->id)->first();
    }

    //set next active team
    public function setNextTeam(Game $game)
    {
        $set_position = $game->currentTeam()->position  + 1;
        $next_team = $game->teams()->where('position', $set_position)->first();
        if (!$next_team) {
            $next_team = $game->teams()->where('position', 1)->first();
        }

        if ($next_team) {
            $this->update($game, ['current_team_id' => $next_team->id]);
        }

        return $next_team;
    }

    public function dereban(Game $game, $settings)
    {
        $current_team_id = false;
        $names = [];

        for ($i = 1; $i <= $settings['teams']; $i++) {
            $data = ['position' => $i];
            $team = service('Api\Team')->createRandom($game, $names, $data);
            $names[] = $team['name'];
            if ($i == 1) {
                $current_team_id  = $team->id;
            }
        }

        $i = 0;
        $position = 1;

        foreach ($game->players->where('status', Player::STATUS_PLAYER)->shuffle()->all() as $player) {
            $team = $game->teams[$i];
            $data = ['position' => $position, 'team_id' => $team->id];
            if ($position == 1) {
                service('Api\Team')->setCurrentPlayer($team, $player);
                $data['is_captain'] = true;
            }

            service('Api\Player')->update($player, $data);

            $i++;
            if ($i >= count($game->teams)) {
                $i = 0;
                $position++;
            }
        }


        return $current_team_id;
    }

    public function derebanSorted(Game $game, $settings)
    {
        $current_team_id = false;
        $names = [];
        $i = 1;

        foreach ($settings['sorted_teams'] as $sorted_team)
        {
            $data = ['position' => $i];
            $team = service('Api\Team')->createRandom($game, $names, $data);
            $names[] = $team['name'];
            if ($i == 1) {
                $current_team_id  = $team->id;
            }
            $i++;

            $position = 1;
            foreach ($sorted_team as $player_id) {
                $player = service('Api\Player')->find($player_id);
                $data = ['position' => $position, 'team_id' => $team->id];
                if ($position == 1) {
                    service('Api\Team')->setCurrentPlayer($team, $player);
                    $data['is_captain'] = true;
                }
    
                service('Api\Player')->update($player, $data);
                $position++;
            }
        }

        return $current_team_id;
    }

    protected function _hash($str)
    {
        $hash = crc32($str);
        $i = 0;
        while($this->gameRepository->checkHash($hash)) {
            $hash = crc32($str.$i);
            $i++;
        }

        return $hash;
    }

    protected function _generateCode()
    {
        mt_srand();
        $code = mt_rand(10000, 99999);
        while($this->gameRepository->checkCode($code)) {
            mt_srand();
            $code = mt_rand(10000, 99999);
        }

        return $code;
    }
}
