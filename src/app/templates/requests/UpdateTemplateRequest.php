<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Update{ModuleName}Request extends FormRequest
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
            'name' => 'required|unique:{moduleTableName}_language,name,' . $this->id . ',{moduleTableName}_id',
            'canonical' => 'required|unique:routers,canonical,' . $this->id . ',module_id',
            'language_id' => 'required|integer',
            //@'{moduleTableName}_catalouge_id' => 'required'

        ];
    }


    public function messages()
    {
        return [
            'language_id.required' => __('validation.requireLanguage')
        ];
    }
}
