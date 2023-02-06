<?php

namespace App\Http\Resources\Api\Word;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Confirm\Item as ConfirmItemResourse;
use App\Http\Resources\Api\Virus\Item as VirusItemResourse;
use App\Http\Resources\Api\Player\Item as PlayerItemResourse;

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

        $virus = $this->viruses()->where('player_id', $this->pivot->player_id)->where('game_id', $this->pivot->game_id)->first();
        $virus_player = $this->viruses_players()->where('player_word.player_id', $this->pivot->player_id)->where('player_word.game_id', $this->pivot->game_id)->first();

        return [
            'id' => $this->id,
            'player_id' => $this->pivot->player_id,
            'is_approved' => $this->pivot->is_approved,
            'is_current' => $this->pivot->is_current,
            'value' => $this->value,
            'virus' => $virus ? new VirusItemResourse($virus) : false,
            'virus_player' => $virus_player ? new PlayerItemResourse($virus_player) : false,
            'confirms' => ConfirmItemResourse::collection($this->confirms()->where('confirm_word.game_id', $this->pivot->game_id)->get()),
        ];
    }
}
