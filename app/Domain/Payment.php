<?php

namespace App\Domain;

use JsonSerializable;

class Payment implements JsonSerializable
{
    private $id, $userId, $amount, $file, $paymentDate;

    function __construct($id, $userId, $amount, $file, $paymentDate)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->amount = $amount;
        $this->file = $file;
        $this->paymentDate = $paymentDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
