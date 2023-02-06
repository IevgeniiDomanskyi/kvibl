<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Locale\Item as LocaleItemResourse;

class Me extends JsonResource
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
            'avatar' => $this->avatar,
            'is_registered' => $this->is_registered,
            'is_mute' => $this->is_mute,
            'locale' => new LocaleItemResourse($this->locale),
            $this->mergeWhen(!empty($this->token), [
                'token' => $this->token,
            ]),
        ];
    }
}
