<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCatalougeRequest extends FormRequest
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
            'name' => 'required|unique:product_catalouge_language,name,' . $this->id . ',product_catalouge_id',
            'canonical' => 'required|unique:routers,canonical,' . $this->id . ',module_id',
            'language_id' => 'required|integer'
        ];
    }


    public function messages()
    {
        return [
            'language_id.required' => __('validation.requireLanguage')
        ];
    }
}
