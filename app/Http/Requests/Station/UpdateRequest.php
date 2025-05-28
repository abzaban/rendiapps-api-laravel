<?php

namespace App\Http\Requests\Station;

use App\Http\Requests\CustomFormRequest;

class UpdateRequest extends CustomFormRequest
{
    public function authorize()
    {
        if (!$this->route('stationId'))
            return false;

        $this->merge(['stationId' => $this->route('stationId')]);
        return true;
    }

    public function rules()
    {
        return [
            'stationId' => 'exists:station,_id',
            'townId' => 'required|exists:town,_id',
            'businessName' => 'required',
            'nickName' => 'required',
            'rfc' => 'required|size:12',
            'email' => 'required|email',
            'cellphones' => 'required|array',
            'cellphones.*' => 'regex:/^\d{10}$/',
            'serverDomain' => 'required',
            'category' => 'required|in:PROPIA,RENTAMOS,SOCIOS,ADMINISTRAMOS',
            'segment' => 'required|integer',
            'stationNumber' => 'required|integer',
            'brand' => 'required|in:SIN MARCA,QUICKGAS,SMARTGAS,PEMEX',
            'legalPermission' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'stationId.exists' => 'Estación no encontrada',
            'townId.required' => 'Campo requerido',
            'townId.exists' => 'Municipio no encontrado',
            'businessName.required' => 'Campo requerido',
            'nickName.required' => 'Campo requerido',
            'nickName.unique' => 'Alias ya registrado',
            'rfc.required' => 'Campo requerido',
            'rfc.size' => 'Es necesario que el campo sea de 12 caracteres',
            'email.required' => 'Campo requerido',
            'email.email' => 'Correo no válido',
            'cellphones.required' => 'Campo requerido',
            'cellphones.array' => 'Debe ser un arreglo',
            'cellphones.*.regex' => 'Celular no válido',
            'serverDomain.required' => 'Campo requerido',
            'category.required' => 'Campo requerido',
            'category.in' => 'Categoria no válida',
            'segment.required' => 'Campo requerido',
            'segment.integer' => 'Debe ser un dígito',
            'stationNumber.required' => 'Campo requerido',
            'stationNumber.integer' => 'Debe ser un dígito',
            'brand.required' => 'Campo requerido',
            'brand.in' => 'Marca no válida',
            'legalPermission.required' => 'Campo requerido'
        ];
    }
}
