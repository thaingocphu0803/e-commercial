<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|unique:product_language,name',
            'canonical' => 'required|unique:routers,canonical',
            'language_id' => 'required|integer',
            'product_catalouge_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'language_id.required' => __('validation.requireLanguage')
        ];
    }
}
