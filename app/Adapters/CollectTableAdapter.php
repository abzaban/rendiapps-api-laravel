<?php

namespace App\Adapters;

use JsonSerializable;

class CollectTableAdapter implements JsonSerializable
{
    private $id, $stationCollectNickName, $stationPayNickName, $status, $amount, $amountRemaining, $file, $debitDate, $created_at, $payments;

    function __construct($id, $stationCollectNickName, $stationPayNickName, $status, $amount, $amountRemaining, $file, $debitDate, $created_at, $payments)
    {
        $this->id = $id;
        $this->stationCollectNickName = $stationCollectNickName;
        $this->stationPayNickName = $stationPayNickName;
        $this->status = $status;
        $this->amount = $amount;
        $this->amountRemaining = $amountRemaining;
        $this->file = $file;
        $this->debitDate = $debitDate;
        $this->created_at = $created_at;
        $this->payments = $payments;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getStationCollectNickName()
    {
        return $this->stationCollectNickName;
    }

    public function setStationCollectNickName($stationCollectNickName)
    {
        $this->stationCollectNickName = $stationCollectNickName;
    }

    public function getStationPayNickName()
    {
        return $this->stationPayNickName;
    }

    public function setStationPayNickName($stationPayNickName)
    {
        $this->stationPayNickName = $stationPayNickName;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmountRemaining()
    {
        return $this->amountRemaining;
    }

    public function setAmountRemaining($amountRemaining)
    {
        $this->amountRemaining = $amountRemaining;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getDebitDate()
    {
        return $this->debitDate;
    }

    public function setDebitDate($debitDate)
    {
        $this->debitDate = $debitDate;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
