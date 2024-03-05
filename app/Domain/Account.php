<?php

namespace App\Domain;

use JsonSerializable;

class Account implements JsonSerializable
{
    private $id, $bankName, $accountNumber, $balances;

    function __construct($id, $bankName, $accountNumber, $balances)
    {
        $this->id = $id;
        $this->bankName = $bankName;
        $this->accountNumber = $accountNumber;
        $this->balances = $balances;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getBankName()
    {
        return $this->bankName;
    }

    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    public function getBalances()
    {
        return $this->balances;
    }

    public function setBalances($balances)
    {
        $this->balances = $balances;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
