<?php

namespace App\Http\Resources\Api\Action;

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
            'id' => $this->id,
            'player_id' => $this->player_id,
            'action' => $this->action,
            'value' => $this->value,
        ];
    }
}
