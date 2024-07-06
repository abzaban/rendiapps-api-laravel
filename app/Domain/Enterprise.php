<?php

namespace App\Domain;

use JsonSerializable;

class Enterprise implements JsonSerializable
{
    private $id, $townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment;

    function __construct($id, $townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment)
    {
        $this->id = $id;
        $this->townId = $townId;
        $this->businessName = $businessName;
        $this->nickName = $nickName;
        $this->rfc = $rfc;
        $this->email = $email;
        $this->cellphones = $cellphones;
        $this->serverDomain = $serverDomain;
        $this->category = $category;
        $this->segment = $segment;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTownId()
    {
        return $this->townId;
    }

    public function setTownId($townId)
    {
        $this->townId = $townId;
    }

    public function getBusinessName()
    {
        return $this->businessName;
    }

    public function setBusinessName($businessName)
    {
        $this->businessName = $businessName;

        return $this;
    }

    public function getNickName()
    {
        return $this->nickName;
    }

    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    }

    public function getRfc()
    {
        return $this->rfc;
    }

    public function setRfc($rfc)
    {
        $this->rfc = $rfc;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCellphones()
    {
        return $this->cellphones;
    }

    public function setCellphones($cellphones)
    {
        $this->cellphones = $cellphones;
    }

    public function getServerDomain()
    {
        return $this->serverDomain;
    }

    public function setServerDomain($serverDomain)
    {
        $this->serverDomain = $serverDomain;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getSegment()
    {
        return $this->segment;
    }

    public function setSegment($segment)
    {
        $this->segment = $segment;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
