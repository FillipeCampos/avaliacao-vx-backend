<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'delivery_days' => 'required',
            'reference' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome do produto obrigatório',
            'price.required' => 'Preço obrigatório',
            'delivery_days.required' => 'Informe os dias para entrega',
            'reference.required' => 'Referência obrigatória'
        ];
    }
}
