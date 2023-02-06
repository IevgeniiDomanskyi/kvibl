<?php

namespace App\Http\Resources\Api\Text;

use Illuminate\Http\Resources\Json\JsonResource;

class All extends JsonResource
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
        return $this->resource;
        /*
        $result = [];
        foreach ($this->resource as $key => $value) {
            $result[$key] = $this->_convertKeys($value);
        }
        return $result;
        */
    }

    protected function _convertKeys(array $array, string $prefix = '')
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->_convertKeys($value, $prefix.$key.'.'));
            } else {
                $result[$prefix.$key] = $value;
            }
        }

        return $result;
    }
}
