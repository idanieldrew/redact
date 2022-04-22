<?php

namespace Module\Post\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'nullable|unique:posts|max:32|min:3',
            'details' => 'nullable|unique:posts|min:10',
            'description' => 'nullable|min:20',
        ];
    }
}