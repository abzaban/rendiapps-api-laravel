<?php

namespace App\Http\Requests\Collect;

use App\Http\Requests\CustomFormRequest;

class SaveRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'stationCollectId' => 'required|exists:station,_id',
            'stationPayId' => 'required|exists:station,_id',
            'amount' => 'required|integer',
            'debitDate' => 'required|date',
            'file' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'stationCollectId.required' => 'Campo requerido',
            'stationCollectId.exists' => 'Estación no encontrada',
            'stationPayId.required' => 'Campo requerido',
            'stationPayId.exists' => 'Estación no encontrada',
            'amount.required' => 'Campo requerido',
            'amount.integer' => 'Monto no válido',
            'debitDate.required' => 'Campo requerido',
            'debitDate.date' => 'Fecha no válida',
            'file.required' => 'Campo requerido'
        ];
    }
}
