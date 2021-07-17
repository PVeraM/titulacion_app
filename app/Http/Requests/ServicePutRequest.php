<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicePutRequest extends FormRequest
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
            'description'   => 'max:200|min:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del servicio es requerido.',
            'name.max' => 'El nombre del servicio debe ser menor a 50 caracteres.',
            'name.min' => 'El nombre del servicio debe ser mayor a 3 caracteres.',

            'description.max' => 'La descripción del servicio debe ser menor a 200 caracteres.',
            'description.min' => 'La descripción del servicio debe ser mayor a 3 caracteres.',
        ];
    }
}
