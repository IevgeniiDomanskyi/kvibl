<?php

namespace App\Http\Resources\Api\Category;

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

        $langs = service('Api\Lang')->all();
        $count_words = [];
        foreach($langs as $lang) {
            $count_words[$lang->code] = $this->words()->where('lang_id', $lang->id)->where('is_active', true)->count();
        }

        $bought = [];
        if (auth()->check()) {
            $me = auth()->user();
            $categories = $me->categories()->where('category_id', $this->id)->get();
            if ($categories) {
                foreach ($categories as $category) {
                    $bought[] = $category->pivot->lang_id;
                }
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->whenLoaded('locales', function() {
                $result = [];
                foreach($this->locales as $locale) {
                    $result[$locale->code] = $locale->pivot->name;
                }
                return $result;
            }),
            'description' => $this->whenLoaded('locales', function() {
                $result = [];
                foreach($this->locales as $locale) {
                    $result[$locale->code] = $locale->pivot->description;
                }
                return $result;
            }),
            'is_free' => $this->is_free,
            'cover_image' => $this->cover_image,
            'words' => $count_words,
            'bought' => $bought,
        ];
    }
}
