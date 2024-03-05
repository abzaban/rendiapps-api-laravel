<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;

class SaveRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:user,email',
            'username' => 'required|min:4|unique:user,username',
            'password' => 'required|min:6',
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
            'firstName.required' => 'Campo requerido',
            'lastName.required' => 'Campo requerido',
            'address.required' => 'Campo requerido',
            'email.required' => 'Campo requerido',
            'email.email' => 'Correo no válido',
            'email.unique' => 'Correo ya registrado',
            'username.required' => 'Campo requerido',
            'username.min' => 'Campo mayor o igual a 4 caracteres',
            'username.unique' => 'Usuario ya registrado',
            'password.required' => 'Campo requerido',
            'password.min' => 'Campo mayor o igual a 6 caracteres',
            'permissions.required' => 'Campo requerido',
            'permissions.enterprises.*.exists' => 'Empresa no encontrada',
            'permissions.stations.*.exists' => 'Estación no encontrada',
            'permissions.modules.*.moduleId.exists' => 'Módulo no encontrado',
            'permissions.modules.*.roleId.integer' => 'Campo no válido'
        ];
    }
}
