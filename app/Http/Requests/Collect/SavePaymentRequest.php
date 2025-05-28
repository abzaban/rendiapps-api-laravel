<?php

namespace App\Http\Requests\Collect;

use App\Http\Requests\Collect\CollectIdRequest;

class SavePaymentRequest extends CollectIdRequest
{
    public function authorize()
    {
        parent::authorize();
        return true;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'amount' => 'required|min:0',
            'paymentDate' => 'required|date',
            'file' => 'required'
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'amount.required' => 'Campo requerido',
            'amount.min' => 'Monto no válido',
            'paymentDate.required' => 'Campo requerido',
            'paymentDate.date' => 'Fecha no válida',
            'file.required' => 'Campo requerido'
        ]);
    }
}
