<?php

namespace Module\Post\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|unique:posts|max:32|min:3',
            'details' => 'required|unique:posts|min:10',
            'description' => 'required',
            'banner' => 'required',
            'attachment' => 'mimes:jpeg,jpg,png,gif|max:20000'
        ];
    }
}
