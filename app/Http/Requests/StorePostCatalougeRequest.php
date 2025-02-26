<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostCatalougeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:post_catalouge_language,name',
            'canonical' => 'required|unique:post_catalouge_language,canonical',
            'language_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'language_id.required' => 'The language is required.'
        ];
    }
}
