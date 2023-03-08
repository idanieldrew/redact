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
    public function rules(): array
    {
        return [
            'title' => 'required|max:32|min:3|unique:posts',
            'details' => 'required|min:10|unique:posts',
            'description' => 'required',
            'banner' => 'required|mimes:png,jpg',
            'attachment' => 'nullable|array',
            'attachment.video.*' => 'file|mimetypes:video/mp4,video/mpeg,video/x-matroska',
            'attachment.image.*' => 'file|mimes:png,jpg',
            'tag' => 'required|array',
            'category' => 'required|array',
        ];
    }
}
