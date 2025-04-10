<?php

namespace App\Http\Requests\Collect;

class RejectCollectRequest extends CollectIdRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), ['rejectedNote' => 'required']);
    }

    public function messages()
    {
        return array_merge(parent::messages(), ['rejectedNote.required' => 'Campo requerido']);
    }
}
