<?php

namespace App\Http\Requests\RecoverPassword;

use App\Http\Requests\CustomFormRequest;

class ResetPasswordRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pwdToken' => 'required|exists:token,pwdToken',
            'password' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'pwdToken.required' => 'Campo requerido',
            'pwdToken.exists' => 'Token no válido para recuperación',
            'password.required' => 'Campo requerido',
            'password.min' => 'Se requieren mínimo 6 caracteres'
        ];
    }
}