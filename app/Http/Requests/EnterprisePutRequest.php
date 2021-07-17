<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnterprisePutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50|min:3'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la empresa es requerido.',
            'name.max' => 'El nombre de la empresa debe ser menor a 50 caracteres.',
            'name.min' => 'El nombre de la empresa debe ser mayor a 3 caracteres.',
        ];
    }
}
