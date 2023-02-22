<?php

namespace Module\Auth\Http\Requests\v2;

use Illuminate\Foundation\Http\FormRequest;

class ChangePsdRequest extends FormRequest
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
            'old_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
