<?php

namespace App\Http\Resources\Api\Virus;

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
            'image' => $this->image,
            'type' => $this->type,
            'count' => (!empty($this->pivot)) ? $this->pivot->count : 0,
            'name' => $this->name(),
            'description' => $this->description(),
        ];
    }
}
