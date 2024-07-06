<?php

namespace App\Http\Requests\Collect;

use App\Http\Requests\CustomFormRequest;

class PaymentIdRequest extends CustomFormRequest
{
    public function authorize()
    {
        if (!$this->route('collectId') || !$this->route('paymentId'))
            return false;

        $this->merge([
            'collectId' => $this->route('collectId'),
            'paymentId' => $this->route('paymentId')
        ]);
        return true;
    }

    public function rules()
    {
        return ['collectId' => 'exists:collect,_id'];
    }

    public function messages()
    {
        return ['collectId.exists' => 'Cobranza no encontrada'];
    }
}
