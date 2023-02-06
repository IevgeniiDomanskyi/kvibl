<?php

namespace App\Http\Middleware;

use Closure;

class Game
{
    public function handle($request, Closure $next, $guard = null)
    {
        $game = $request->game;
        $me = auth()->user();
        if (!$game->players->contains('user_id', $me->id)) {
            return response()->message('game.message.not_in_game', 'error', 422);
        }

        if (!empty($request->player)) {
            if (!$game->players->contains('id', $request->player->id)) {
                return response()->message('game.message.not_in_game', 'error', 422);
            }
        }

        return $next($request);
    }
}
