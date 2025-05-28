<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;

class UpdateStationsRequest extends CustomFormRequest
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
            'stations' => 'required|array',
            'stations.*' => 'exists:station,_id'
        ];
    }

    public function messages()
    {
        return [
            'userId.exists' => 'Usuario no encontrado',
            'stations.required' => 'Campo requerido',
            'stations.array' => 'Debe ser un arreglo',
            'stations.*.exists' => 'Estación no encontrada'
        ];
    }
}
