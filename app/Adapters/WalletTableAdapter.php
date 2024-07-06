<?php

namespace App\Adapters;

use JsonSerializable;

class WalletTableAdapter implements JsonSerializable
{
    private $id, $ownerNickName, $accounts;

    public function __construct($id, $ownerNickName, $accounts)
    {
        $this->id = $id;
        $this->ownerNickName = $ownerNickName;
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

    public function getOwnerNickName()
    {
        return $this->ownerNickName;
    }

    public function setOwnerNickName($ownerNickName)
    {
        $this->ownerNickName = $ownerNickName;
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
