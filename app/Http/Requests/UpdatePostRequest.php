<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'name' => 'required|unique:post_language,name,' . $this->id . ',post_id',
            'canonical' => 'required|unique:post_language,canonical,' . $this->id . ',post_id',
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
