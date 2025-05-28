<?php

namespace App\Http\Requests\Enterprise;

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
            'townId' => 'required|exists:town,_id',
            'businessName' => 'required',
            'nickName' => 'required',
            'rfc' => 'required|size:12',
            'email' => 'required|email',
            'cellphones' => 'required|array',
            'cellphones.*' => 'regex:/^\d{10}$/',
            'serverDomain' => 'required',
            'category' => 'required|in:PROPIA,RENTAMOS,SOCIOS,ADMINISTRAMOS',
            'segment' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
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
            'segment.integer' => 'Debe ser un dígito'
        ];
    }
}
