<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;

class UpdateRequest extends CustomFormRequest
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
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'permissions' => 'required|array',
            'permissions.enterprises.*' => 'exists:enterprise,_id',
            'permissions.stations.*' => 'exists:station,_id',
            'permissions.modules.*.moduleId' => 'exists:module,_id',
            'permissions.modules.*.roleId' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'userId.exists' => 'Usuario no encontrado',
            'firstName.required' => 'Campo requerido',
            'lastName.required' => 'Campo requerido',
            'address.required' => 'Campo requerido'
        ];
    }
}
