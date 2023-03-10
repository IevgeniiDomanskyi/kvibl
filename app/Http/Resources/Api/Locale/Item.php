<?php

namespace App\Http\Resources\Api\Locale;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CustomData;

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
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'default' => $this->default,
        ];
    }
}
