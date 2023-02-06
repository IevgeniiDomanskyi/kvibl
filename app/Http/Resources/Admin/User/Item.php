<?php

namespace App\Http\Resources\Admin\User;

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
            'email' => $this->email,
            'name' => $this->name,
            'is_registered' => $this->is_registered,
            'avatar' => $this->avatar,
        ];
    }
}
