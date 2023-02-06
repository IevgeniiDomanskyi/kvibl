<?php

namespace App\Http\Resources\Admin\Word;

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
            'value' => $this->value,
            'count_show' => $this->count_show,
            'count_success' => $this->count_success,
            'is_active' => $this->is_active,
            'code' => service('Api\Lang')->get($this->lang_id)->code,
        ];
    }
}
