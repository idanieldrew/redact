<?php

namespace Module\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => ['required','string'],
            'email' => ['required','email','digits:11','unique:users,email']
        ];
            if (request()->method === 'PATCH'){
                $rules['name'] = ['nullable','string','min:3','max:16'. request()->id];
                $rules['email'] = ['nullable','email','digits:11','unique:users,email' . request()->id];
            }

        return [
           $rules
        ];
    }
}
