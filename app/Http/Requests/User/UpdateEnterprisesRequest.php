<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;

class UpdateEnterprisesRequest extends CustomFormRequest
{
    public function authorize()
    {
        if (!$this->route('userId'))
            return false;

        $this->merge(['userId' => $this->route('userId')]);
        return true;
    }

    public function rules()
    {
        return [
            'userId' => 'exists:user,_id',
            'enterprises' => 'required|array',
            'enterprises.*' => 'exists:enterprise,_id'
        ];
    }

    public function messages()
    {
        return [
            'userId.exists' => 'Usuario no encontrado',
            'enterprises.required' => 'Campo requerido',
            'enterprises.array' => 'Debe ser un arreglo',
            'enterprises.*.exists' => 'Empresa no encontrada'
        ];
    }
}
