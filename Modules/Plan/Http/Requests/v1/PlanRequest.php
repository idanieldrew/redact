<?php

namespace Module\Plan\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->exists;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:plans',
            'count_account' => 'required|numeric|min:1',
            'description' => 'required|array',
            'price' => 'required|numeric',
            'period' => 'required|numeric',
            'interval' => 'required|string',
            'features' => 'required|array'
        ];
    }
}
