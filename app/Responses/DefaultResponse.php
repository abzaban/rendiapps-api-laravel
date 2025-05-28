<?php

namespace App\Responses;

use JsonSerializable;

class DefaultResponse implements JsonSerializable
{
    private $error, $msg, $payload;

    public function __construct($error = false, $msg = "null", $payload = null)
    {
        $this->error = $error;
        $this->msg = $msg;
        $this->payload = $payload;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
