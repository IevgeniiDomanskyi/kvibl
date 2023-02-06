<?php

use Illuminate\Support\Facades\Broadcast;
use App\Game;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('game.{id}', function ($user, $gameId) {
    $player = false;
    $game = Game::where('id', $gameId)->first();
    if ( ! empty($game)) {
        $player = $game->players()->where('user_id', $user->id)->first();
    }
    return ( ! empty($player)) ? $player->hash : false;
});
