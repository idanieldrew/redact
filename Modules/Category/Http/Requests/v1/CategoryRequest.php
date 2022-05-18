<?php

namespace Module\Category\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
          'name' => ['required','string','unique:categories','max:32','min:3']
        ];

        if (request()->method == 'PATCH'){
            $rules['name'] = ['nullable','string','unique:categories','max:32','min:3'];
        }

        return [$rules];
    }
}