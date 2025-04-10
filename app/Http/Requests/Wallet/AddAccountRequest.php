<?php

namespace App\Http\Requests\Wallet;

class AddAccountRequest extends WalletIdRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'bankName' => 'required',
            'accountNumber' => 'required|min:14|max:19'
        ]);
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'bankName.required' => 'Campo requerido',
            'accountNumber.required' => 'Campo requerido',
            'accountNumber.min' => 'Mínimo de 14 caracteres',
            'accountNumber.max' => 'Máximo de 19 caracteres'
        ]);
    }
}
