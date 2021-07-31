<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentPostRequest extends FormRequest
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
            'description'   => 'required|max:200|min:3',
            'ranking'       => ['required', Rule::in([1, 2, 3, 4, 5])],
            'service_id'    => 'required',
            'enterprise_id' => 'required',
            'store_id'      => 'required',
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
            'description.required' => 'La descripción del comentario es requerida.',
            'description.max' => 'La descripción del comentario debe ser menor a 200 caracteres.',
            'description.min' => 'La descripción del comentario debe ser mayor a 3 caracteres.',

            'ranking.required' => 'La valoración del comentario es requerida.',
            'ranking.in' => 'La valoración es del 1 al 5.',

            'service_id.required' => 'El id del servicio es requerido.',
            'enterprise_id.required' => 'El id de la empresa es requerido.',
            'store_id.required' => 'El id de la tienda es requerido.',
        ];
    }
}
