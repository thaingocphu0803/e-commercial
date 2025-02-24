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
            'name' => 'required',
            'canonical' => 'required|unique:post_catalouge_language,canonical,' . $this->post_catalouge_id . ',post_catalouge_id',
            'language_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'language_id' => 'The language is required.'
        ];
    }
}
