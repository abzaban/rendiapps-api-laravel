<?php

namespace App\Http\Requests\Collect;

use App\Http\Requests\CustomFormRequest;

class CollectIdRequest extends CustomFormRequest
{
    public function authorize()
    {
        if (!$this->route('collectId'))
            return false;

        $this->merge(['collectId' => $this->route('collectId')]);
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
