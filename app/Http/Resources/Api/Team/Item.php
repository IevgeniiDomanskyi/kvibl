<?php

namespace App\Http\Resources\Api\Team;

use Illuminate\Http\Resources\Json\JsonResource;

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

        return [
            'team_id' => $this->id,
            'color' => $this->color->code,
            'position' => $this->position,
            'current_player_id' => $this->current_player_id,
            'score' => $this->score,
            'name' => $this->name,
            'is_winner' => $this->is_winner,
        ];
    }
}
