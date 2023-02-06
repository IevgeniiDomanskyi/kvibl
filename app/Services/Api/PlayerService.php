<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Repositories\PlayerRepository;
use App\Events\Api\Game\PlayersChange as PlayersChangeEvent;
use App\Events\Api\Team\TeamChange as TeamChangeEvent;
use App\Events\Api\Game\GameChange as GameChangeEvent;
use Carbon\Carbon;
use App\Game;
use App\Player;

class PlayerService extends Service
{
    protected $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function find($id)
    {
        return $this->playerRepository->find($id);
    }

    public function get(Game $game)
    {
        return $game->players;
    }

    public function getByHash($hash)
    {
        return $this->playerRepository->getByHash($hash);
    }

    public function update(Player $player, $data)
    {
        return $this->playerRepository->update($player, $data);
    }

    public function finish(Game $game, Player $player)
    {
        $this->playerRepository->setFinished($game, $player);

        service('Api\Game')->update($game, ['status' => Game::STATUS_WORDS_CONFIRM]);

        event(new GameChangeEvent($game));

        return $player;
    }

    //Confirm round words by captain
    public function confirm(Game $game, Player $player)
    {
        if ($game->status != Game::STATUS_WORDS_CONFIRM) {
            return response()->message('game.message.game_wrong_status', 'error', 422);
        }

        if ($player->is_approved) {
            return response()->message('game.message.already_approved', 'error', 422);
        }

        $player = $this->playerRepository->update($player, ['is_approved' => true]);

        if (!$game->captains()->where('id', '<>', $game->currentTeamCaptain()->id)->where('is_approved', false)->exists()) {

            service('Api\Game')->update($game, ['status' => Game::STATUS_AWARDS]);
            event(new GameChangeEvent($game));

            $confirms = $game->confirms()->where('is_owner', false)->get();
            $words = [];
            foreach ($confirms as $confirm) {
                if (!isset($words[$confirm->id])) {
                    $words[$confirm->id] = 0;
                }
                $words[$confirm->id] += $confirm->pivot->is_approved*1;
            }

            $score = 0;
            foreach ($words as $id => $approve_count) {
                if (round($approve_count / count($game->captains)) >= 1) {
                    service('Api\Word')->increaseSuccess($id);
                    $score++;
                }
            }

            $this->playerRepository->update($game->currentPlayer(), ['score' => $game->currentPlayer()->score + $score]);

            foreach ($game->captains as $captain) {
                $player = $this->playerRepository->update($captain, ['is_approved' => false]);
            }

            event(new PlayersChangeEvent($player->game));

            service('Api\Team')->update($game->currentTeam(), ['score' => $game->currentTeam()->score + $score]);

            event(new TeamChangeEvent($game));
        }

        return $player;
    }

    //Get player awards and finish round
    public function awards(Game $game, Player $player)
    {
        if ($player->id = $game->currentPlayer()->id && $game->status == Game::STATUS_AWARDS) {

            $game->confirms()->detach();

            $nextPlayer = service('Api\Team')->setNextPlayer($game->currentTeam());

            $nextTeam = service('Api\Game')->setNextTeam($game);

            $lap = $nextTeam->position == 1 ? $game->lap +1 : $game->lap;
            $status = Game::STATUS_MAIN;
            $complete = false;

            if ($lap > $game->lap) {
                $winner = false;
                foreach ($game->teams as $team) {
                    if ($team->score >= config('game.win_score')) {
                        if (!$winner || $team->score > $winner->score) {
                            $winner = $team;
                        }
                    }
                }

                if ($winner) {
                    service('Api\Team')->update($winner, ['is_winner' => true]);
                    event(new TeamChangeEvent($game));

                    $status = Game::STATUS_FINISHED;
                    $complete = true;
                }
            }

            service('Api\Game')->update($game, ['status' => $status, 'lap' => $lap, 'complete' => $complete]);
        }

        return $player;
    }

    public function prepare(Game $game, Player $player)
    {
        service('Api\Game')->update($game, ['status' => Game::STATUS_PREPARE]);

        event(new GameChangeEvent($game));

        return $player;
    }

    public function updateName(Player $player, $data)
    {
        if ($data['status'] != 2) {
            service('Api\User')->update($player->user, ['name' => $data['name']]);
        }

        if (!empty($data['avatar'])) {
            service('Api\User')->update($player->user, ['avatar' => $data['avatar']]);
        }

        $player = $this->playerRepository->update($player, $data);

        event(new PlayersChangeEvent($player->game));

        return $player;
    }

    public function add(Game $game, Player $player, Player $addingPlayer, $team_id)
    {
        if (!$player->is_owner) {
            return response()->message('game.message.player_add_not_owner', 'error', 422);
        }

        $team = $game->teams()->find($team_id);
        if (empty($team)) {
            return response()->message('game.message.team_empty', 'error', 422);
        }

        $addingPlayer = $this->playerRepository->update($addingPlayer, ['status' => 1, 'position' => count($team->players) + 1, 'team_id' => $team->id]);
        $game->load('players');

        event(new PlayersChangeEvent($player->game));

        return $addingPlayer;
    }

    public function updateTab(Player $player, $data)
    {
        $player = $this->playerRepository->update($player, $data);
        return $player;
    }

    public function online(Player $player, $online)
    {
        $data = ['is_online' => $online];
        $player = $this->playerRepository->update($player, $data);

        event(new PlayersChangeEvent($player->game));

        return $player;
    }

    public function leave(Game $game, Player $player)
    {
        if ($player->is_owner && count($game->players) > 1) {
            if ($random_player = $this->playerRepository->randomPlayer($game, $player)) {
                $this->playerRepository->update($random_player, ['is_owner' => true]);
            }
        }

        $team = $player->team;

        if ($team) {
            if ($team->current_player_id == $player->id) {
                $nextPlayer = service('Api\Team')->setNextPlayer($team);
                event(new TeamChangeEvent($game));
                event(new GameChangeEvent($game));
            }

            if ($player->is_captain) {
                $this->setNextCaptain($team);
            }
        }

        $this->playerRepository->remove($player->id);

        if ($team) {
            $team->load('players');

            if (count($team->players) < 2) {
                service('Api\Game')->remove($game->id);
                return true;
            }

            for ($i = 0; $i < count($team->players); $i++) {
                $this->playerRepository->update($team->players[$i], ['position' => $i+1]);
            }
        }

        $game->load('players');
        if (count($game->players) == 0) {
            service('Api\Game')->remove($game->id);
        } else {
            event(new PlayersChangeEvent($game));
        }

        return true;
    }

    public function remove(Game $game, Player $player, Player $removingPlayer)
    {
        if (!$player->is_owner) {
            return response()->message('game.message.player_remove_not_owner', 'error', 422);
        }

        $team = $removingPlayer->team;

        if ($team) {
            if ($team->current_player_id == $removingPlayer->id) {
                $nextPlayer = service('Api\Team')->setNextPlayer($team);
                event(new TeamChangeEvent($game));
                event(new GameChangeEvent($game));
            }

            if ($removingPlayer->is_captain) {
                $this->setNextCaptain($team);
            }
        }

        $this->playerRepository->remove($removingPlayer->id);

        if ($team) {
            $team->load('players');

            if (count($team->players) < 2) {
                service('Api\Game')->remove($game->id);
                return true;
            }

            for ($i = 0; $i < count($team->players); $i++) {
                $this->playerRepository->update($team->players[$i], ['position' => $i+1]);
            }
        }

        $game->load('players');
        if (count($game->players) == 0) {
            service('Api\Game')->remove($game->id);
        } else {
            event(new PlayersChangeEvent($game));
        }

        return true;
    }

    public function setNextCaptain($team) {
        $current_player = $team->players()->where('is_captain', true)->first();
        $next_player = $team->players()->where('is_captain', false)->first();

        if ($next_player && $current_player) {
            $current_player = $this->playerRepository->update($current_player, ['is_captain' => false]);
            $next_player = $this->playerRepository->update($next_player, ['is_captain' => true]);
        }

        return $next_player;
    }

    public function push(Game $game, Player $player)
    {
        event(new PlayersChangeEvent($game));
    }

    public function hash($str)
    {
        $hash = crc32($str);
        $i = 0;
        while($this->playerRepository->getByHash($hash)) {
            $hash = crc32($str.$i);
            $i++;
        }

        return $hash;
    }
}
