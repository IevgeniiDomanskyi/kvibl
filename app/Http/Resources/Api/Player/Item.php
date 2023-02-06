<?php

namespace App\Http\Resources\Api\Player;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Virus\Item as VirusItemResourse;

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
            'team_id' => $this->team_id,
            'user_id' => $this->user_id,
            'player_id' => $this->id,
            'name' => $this->user->name,
            'avatar' => $this->user->avatar,
            'score' => $this->score,
            'status' => $this->status,
            'tab' => $this->tab,
            'position' => $this->position,
            'is_disabled' => $this->is_disabled,
            'is_approved' => $this->is_approved,
            'is_online' => $this->is_online,
            'is_owner' => $this->is_owner,
            'is_captain' => $this->is_captain,
            'hash' => $this->hash,
            'viruses' => VirusItemResourse::collection($this->viruses_bag),
            'attached_viruses' => VirusItemResourse::collection($this->viruses),
        ];
    }
}
