<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'post_text' => 'string',
            'post_url' => 'nullable|url',
            // 'post_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
