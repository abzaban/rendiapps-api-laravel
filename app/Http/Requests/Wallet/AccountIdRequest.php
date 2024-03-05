<?php

namespace App\Http\Requests\Wallet;

class AccountIdRequest extends WalletIdRequest
{
    public function authorize()
    {
        parent::authorize();

        if (!$this->route('accountId'))
            return false;

        $this->merge(['accountId' => $this->route('accountId')]);
        return true;
    }

    public function rules()
    {
        return array_merge(parent::rules(), ['accountId.exists' => 'exists:collect,accounts._id']);
    }

    public function messages()
    {
        return array_merge(parent::messages(), ['accountId.exists' => 'Cuenta no encontrada']);
    }
}
