<?php

namespace App\Http\Requests\Admin\Word;

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
            'value' => 'required|string',
            'category_id' => 'numeric',
            'lang_id' => 'required|numeric',
            'is_active' => 'boolean',
        ];
    }
}
