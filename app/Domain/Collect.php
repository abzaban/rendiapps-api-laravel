<?php

namespace App\Domain;

use JsonSerializable;

class Collect implements JsonSerializable
{
    private $id, $stationCollectId, $stationPayId, $status, $amount, $file, $debitDate, $payments;

    function __construct($id, $stationCollectId, $stationPayId, $status, $amount, $file, $debitDate, $payments)
    {
        $this->id = $id;
        $this->stationCollectId = $stationCollectId;
        $this->stationPayId = $stationPayId;
        $this->status = $status;
        $this->amount = $amount;
        $this->file = $file;
        $this->debitDate = $debitDate;
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

    public function getStationCollectId()
    {
        return $this->stationCollectId;
    }

    public function setStationCollectId($stationCollectId)
    {
        $this->stationCollectId = $stationCollectId;
    }

    public function getStationPayId()
    {
        return $this->stationPayId;
    }

    public function setStationPayId($stationPayId)
    {
        $this->stationPayId = $stationPayId;
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
