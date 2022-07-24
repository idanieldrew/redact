<?php

namespace Module\User\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|max:32|min:3',
            'email' => 'nullable|unique:users|min:10',
            'permission' => 'nullable|exists:permissions,name',
            'role' => 'nullable|exists:roles,name',
        ];
    }
}
