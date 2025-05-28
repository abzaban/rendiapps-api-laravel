<?php

namespace App\Http\Requests\financesController;

use App\Http\Requests\CustomFormRequest;

class UpdateAccountRequest extends CustomFormRequest
{
    public function authorize()
    {
        if (!$this->route('walletId') || !$this->route('accountId'))
            return false;

        $this->merge([
            'walletId' => $this->route('walletId'),
            'accountId' => $this->route('accountId')
        ]);
        return true;
    }

    public function rules()
    {
        return [
            'banco' => 'required',
            'noCuenta' => 'required|min:14|max:19'
        ];
    }

    public function messages()
    {
        return [
            'banco.required' => 'Banco requerido',
            'noCuenta.required' => 'No. de cuenta requerido',
            'noCuenta.min' => 'Es necesario que el no. de cuenta sea mínimo de 14 caracteres',
            'noCuenta.max' => 'Es necesario que el no. de cuenta sea máximo de 19 caracteres'
        ];
    }

    public function attributes()
    {
        return [
            'banco' => $this->input('banco'),
            'noCuenta' => $this->input('noCuenta'),
            'walletId' => $this->input('walletId'),
            'accountId' => $this->input('accountId')
        ];
    }
}
