<?php

namespace App\Http\Requests\RecoverPassword;

use App\Http\Requests\CustomFormRequest;

class ResetPasswordViewRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['pwdToken' => 'required'];
    }

    public function messages()
    {
        return ['pwdToken.required' => 'Campo requerido'];
    }
}
