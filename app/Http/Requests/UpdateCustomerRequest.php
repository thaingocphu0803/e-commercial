<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
                "email" => 'required|email|unique:customers,email,'.$this->id,
                "name" => 'required|string',
                "phone" => 'nullable|digits_between:10,13',
                "customer_catalouge_id" => 'required|integer',
                "gender" => 'required'
            ];
    }
}
