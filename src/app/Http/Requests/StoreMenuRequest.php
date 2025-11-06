<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            'menu_catalouge_id' => 'required',
            'menu.name' => 'required'
        ];
    }

        public function messages()
    {
        return [
            'menu_catalouge_id.required' => __('validation.requireMenuPosition'),
            'menu.name.required' => __('validation.menuRequired')
        ];
    }
}
