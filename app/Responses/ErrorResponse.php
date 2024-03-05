<?php

namespace App\Responses;

use JsonSerializable;

class ErrorResponse extends DefaultResponse implements JsonSerializable
{
    private $errors;

    function __construct($errors = [])
    {
        $this->setError(true);
        $this->setMsg('Error con el cuerpo de la solicitud');
        $this->errors = $errors;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return array_merge(parent::jsonSerialize(), $vars);
    }
}
