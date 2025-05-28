<?php

namespace App\Responses;

use JsonSerializable;

class AuthResponse extends DefaultResponse implements JsonSerializable
{
    private $token;

    function __construct($error = false, $msg = 'null', $payload = null, $token = null)
    {
        parent::__construct($error, $msg, $payload);
        $this->token = $token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        $vars['ra_token'] = $vars['token'];
        unset($vars['token']);

        return array_merge(parent::jsonSerialize(), $vars);
    }
}
