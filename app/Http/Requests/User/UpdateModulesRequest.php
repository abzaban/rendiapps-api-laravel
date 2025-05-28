<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;

class UpdateModulesRequest extends CustomFormRequest
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
            'modules' => 'required|array',
            'modules.*.moduleId' => 'exists:module,_id',
            'modules.*.roleId' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'userId.exists' => 'Usuario no encontrado',
            'modules.required' => 'Campo requerido',
            'modules.array' => 'Debe ser un arreglo',
            'modules.*.moduleId.exists' => 'Módulo no encontrado',
            'modules.*.roleId.required' => 'Atributo requerido'
        ];
    }
}
