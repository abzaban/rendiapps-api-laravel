<?php

namespace App\Http\Requests\Collect;

use App\Http\Requests\CustomFormRequest;

class GetTableAdapterInDateRangeRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'startDate' => 'required',
            'endDate' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'startDate.required' => 'Campo requerido',
            'endDate.required' => 'Campo requerido'
        ];
    }
}
