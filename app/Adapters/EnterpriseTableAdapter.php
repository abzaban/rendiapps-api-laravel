<?php

namespace App\Adapters;

use JsonSerializable;

class EnterpriseTableAdapter implements JsonSerializable
{
    private $id, $townName, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment;

    function __construct($id, $townName, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment)
    {
        $this->id = $id;
        $this->townName = $townName;
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

    public function getTownName()
    {
        return $this->townName;
    }

    public function setTownName($townName)
    {
        $this->townName = $townName;
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
