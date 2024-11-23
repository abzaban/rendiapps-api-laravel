<?php

namespace App\Http\Requests\financesController;

use App\Http\Requests\CustomFormRequest;

class AddAccountRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ownerId' => 'required',
            'bankName' => 'required',
            'accountNumber' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ownerId.required' => 'Propietario requerido',
            'bankName.required' => 'Banco requerido',
            'accountNumber.required' => 'No. de cuenta requerido'
        ];
    }
}
