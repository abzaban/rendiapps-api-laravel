<?php

namespace App\Http\Requests\Wallet;

use App\Http\Requests\CustomFormRequest;

class WalletIdRequest extends CustomFormRequest
{
    public function authorize()
    {
        if (!$this->route('ownerId'))
            return false;

        $this->merge(['ownerId' => $this->route('ownerId')]);
        return true;
    }

    public function rules()
    {
        return ['ownerId' => 'exists:collect,_id'];
    }

    public function messages()
    {
        return ['ownerId.exists' => 'Cartera no encontrada'];
    }
}
