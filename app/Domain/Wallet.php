<?php

namespace App\Domain;

use JsonSerializable;

class Wallet implements JsonSerializable
{
    private $id, $accounts;

    public function __construct($id, $accounts)
    {
        $this->id = $id;
        $this->accounts = $accounts;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAccounts()
    {
        return $this->accounts;
    }

    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
