<?php

namespace App\Http\Requests\Department;

use App\Http\Requests\CustomFormRequest;

class IdRequest extends CustomFormRequest
{
    public function authorize()
    {
        if (!$this->route('departmentId'))
            return false;

        $this->merge(['departmentId' => $this->route('departmentId')]);
        return true;
    }

    public function rules()
    {
        return ['departmentId' => 'exists:department,_id'];
    }

    public function messages()
    {
        return ['departmentId.exists' => 'Departamento no encontrado'];
    }
}
