<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\CustomFormRequest;

class TokenRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ra_token' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ra_token.required' => 'Campo requerido',
        ];
    }
}
