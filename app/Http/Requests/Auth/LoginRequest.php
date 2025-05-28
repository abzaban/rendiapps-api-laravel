<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\CustomFormRequest;

class LoginRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'authValue' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'authValue.required' => 'Campo requerido',
            'password.required' => 'Campo requerido'
        ];
    }

    public function attributes()
    {
        return [
            'authValue' => $this->input('authValue'),
            'password' => $this->input('password')
        ];
    }
}
