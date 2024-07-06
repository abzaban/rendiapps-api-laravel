<?php

namespace App\Http\Requests\financesController;

use App\Http\Requests\CustomFormRequest;

class AddBalanceRequest extends CustomFormRequest
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
            'capital' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'capital.required' => 'Monto de capital requerido'
        ];
    }

    public function attributes()
    {
        return [
            'capital' => $this->input('capital'),
            'walletId' =>  $this->input('walletId'),
            'accountId' => $this->input('accountId')
        ];
    }
}
