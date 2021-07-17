<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePutRequest extends FormRequest
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
            'name'          => 'required|max:50|min:3',
            'address'       => 'max:200|min:3',
            'enterprise_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'enterprise_id.required' => 'El id de la empresa es requerido.',

            'name.required' => 'El nombre de la tienda es requerido.',
            'name.max' => 'El nombre de la tienda debe ser menor a 50 caracteres.',
            'name.min' => 'El nombre de la tienda debe ser mayor a 3 caracteres.',

            'address.max' => 'La dirección de la tienda debe ser menor a 200 caracteres.',
            'address.min' => 'La dirección de la tienda debe ser mayor a 3 caracteres.',
        ];
    }
}
