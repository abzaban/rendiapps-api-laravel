<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;

class UpdatePasswordRequest extends CustomFormRequest
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
            'password' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'userId.exists' => 'Usuario no encontrado',
            'password.required' => 'Campo requerido'
        ];
    }
}
