<?php

namespace App\Http\Requests\Department;

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
            'name' => 'required',
            'ownerId' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Campo requerido',
            'ownerId.required' => 'Campo requerido'
        ];
    }
}
