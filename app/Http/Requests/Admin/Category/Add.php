<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\ApiRequest;

class Add extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|array',
            'description' => 'required|array',
            'is_active' => 'boolean',
            'is_free' => 'boolean',
            'cover_image' => 'array',
        ];
    }
}
