<?php

namespace App\Http\Resources\Api\Confirm;

use Illuminate\Http\Resources\Json\JsonResource;
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
        return [
            'player_id' => $this->pivot->player_id,
            'is_owner' => $this->pivot->is_owner,
            'is_approved' => $this->pivot->is_approved,
            'is_finished' => $this->pivot->is_finished,
        ];
    }
}
