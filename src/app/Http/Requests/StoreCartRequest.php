<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
            'fullname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'province_id.required' => __('custom.attrIsRequired', ['attribute' => __('custom.city')]),
            'district_id.required' => __('custom.attrIsRequired', ['attribute' => __('custom.district')]),
            'ward_id.required' => __('custom.attrIsRequired', ['attribute' => __('custom.ward')]),
        ];
    }
}
