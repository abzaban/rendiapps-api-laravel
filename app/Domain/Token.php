<?php

namespace App\Domain;

use JsonSerializable;

class Token implements JsonSerializable
{
    private $id, $authToken, $pwdToken;

    function __construct($id, $authToken, $pwdToken)
    {
        $this->id = $id;
        $this->authToken = $authToken;
        $this->pwdToken = $pwdToken;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }

    public function getPwdToken()
    {
        return $this->pwdToken;
    }

    public function setPwdToken($pwdToken)
    {
        $this->pwdToken = $pwdToken;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
