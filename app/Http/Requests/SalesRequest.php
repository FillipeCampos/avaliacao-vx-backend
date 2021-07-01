<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'purchase_at' => 'required|date|before:tomorrow',
            'delivery_days' => 'required',
            'amount' => 'required',
            'products'=>'required'
        ];
    }

    public function messages()
    {
        return [
          'purchase_at.required' => 'Data compra necessária',
          'delivery_days.required' => 'Informe os dias para entrega',
          'amount.required' => 'Informe a quantidade',
          'products.required' => 'Informe os produtos'
        ];
    }
}
