<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Game;
use App\User;
use App\Team;

class GameRepository
{
    public function get($id)
    {
        return Game::find($id);
    }

    public function getByCode($code)
    {
        return Game::where('code', $code)->first();
    }

    public function create()
    {
        return Game::create();
    }

    public function update(Game $game, array $data)
    {
        $game->fill($data);
        $game->save();
        return $game;
    }

    public function attach(Game $game, User $user, array $data = [])
    {
        if ( ! $game->users()->where('user_id', $user->id)->exists()) {
            $game->users()->attach($user->id, $data);
        }

        return $game;
    }

    public function checkHash($hash)
    {
        return Game::where('hash', $hash)->first();
    }

    public function checkCode($code)
    {
        return Game::where('code', $code)->first();
    }

    public function last(User $user)
    {
        $last_game = $user->games()->where('complete', false)->whereHas('players', function($q) {
            $q->where('is_disabled', false);
        })->orderBy('created_at', 'desc')->first();

        if ($last_game) {
            $olderIds = $user->games()->where('complete', false)->where('games.id', '<', $last_game->id)->whereHas('players', function($q) {
                $q->where('is_disabled', false);
            })->pluck('games.id')->toArray();

            foreach ($olderIds as $id) {
                $this->forget($user, $id);
            }
        }

        return $last_game;
    }

    public function forget(User $user, $id)
    {
        return $user->games()->updateExistingPivot($id, ['is_disabled' => true]);
    }

    public function clear()
    {
        $games = Game::where('created_at', '<=', Carbon::now()->subDays(Game::DAYS_TO_CLEAR))->get();

        $games->each(function($game) {
            $this->remove($game->id);
        });
    }

    public function remove($id)
    {
        $game = Game::find($id);

        // remove teams
        $game->teams->each(function($team) {
            $team->delete();
        });

        // remove players
        $game->players->each(function($player) {
            $player->delete();
        });

        // remove game
        $game->delete();
    }
}
