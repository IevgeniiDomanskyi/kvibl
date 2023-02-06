<?php

namespace App\Http\Resources\Api\Game;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Player\Item as PlayerItemResourse;
use Carbon\Carbon;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return null;
        }

        $current_player_id = 0;
        if (!empty($this->current_team_id)) {
            if ($team = $this->teams->find($this->current_team_id)) {
                $current_player_id = $team->current_player_id;
            }
        }

        $diff = !empty($this->round_at) ? config('game.round_time') - now()->diffInSeconds($this->round_at) : config('game.round_time');

        return [
            'id' => $this->id,
            'hash' => $this->hash,
            'code' => $this->code,
            'time' => ($diff < 0) ? 0 : $diff,
            'current_team_id' => $this->current_team_id,
            'current_player_id' => $current_player_id,
            'status' => $this->status,
            'lap' => $this->lap,
            'complete' => $this->complete,
            'config' => config('game'),
        ];
    }
}
