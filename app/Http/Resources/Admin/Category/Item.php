<?php

namespace App\Http\Resources\Admin\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Word\Item as WordResource;

class Item extends JsonResource
{
    public $preserveKeys = true;
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
            'name' => $this->whenLoaded('locales', function() {
                $result = [];
                foreach($this->locales as $locale) {
                    $result[$locale->id] = $locale->pivot->name;
                }
                return $result;
            }),
            'description' => $this->whenLoaded('locales', function() {
                $result = [];
                foreach($this->locales as $locale) {
                    $result[$locale->id] = $locale->pivot->description;
                }
                return $result;
            }),
            'is_active' => $this->is_active,
            'is_free' => $this->is_free,
            'code' => $this->whenLoaded('locales', function() {
                $result = [];
                foreach($this->locales as $locale) {
                    $locale_id = $locale->pivot->locale_id;
                    $result[$locale->id] = service('Admin\Locale')->get($locale_id)->code;
                }
                return $result;
            }),
            'words' => $this->words ? WordResource::collection($this->words) : '',
            'count_words' => $this->words ? WordResource::collection($this->words)->count() : '',
        ];
    }
}
