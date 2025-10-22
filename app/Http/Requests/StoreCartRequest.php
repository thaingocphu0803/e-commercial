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
            'customer.fullname' => 'required',
            'customer.phone' => 'required',
            'customer.email' => 'required|email',
            'customer.address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'customer.fullname.required' => __('custom.attrRequired', [':attribute' => __('custom.fullname')]),
            'customer.phone.required' => __('custom.attrRequired', [':attribute' => __('custom.phone')]),
            'customer.email.required' => __('custom.attrRequired', [':attribute' => __('custom.email')]),
            'customer.address.required' => __('custom.attrRequired', [':attribute' => __('custom.address')]),
        ];
    }
}
