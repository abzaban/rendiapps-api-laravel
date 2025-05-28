<?php

namespace App\Http\Requests\RecoverPassword;

use App\Http\Requests\CustomFormRequest;

class SendMailRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:user,email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Campo requerido',
            'email.email' => 'Correo no válido',
            'email.exists' => 'Usuario no encontrado'
        ];
    }
}
