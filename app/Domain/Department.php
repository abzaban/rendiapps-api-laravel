<?php

namespace App\Domain;

use JsonSerializable;

class Department implements JsonSerializable
{
    private $id, $name, $ownerId, $positions;

    function __construct($id, $name, $ownerId, $positions)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ownerId = $ownerId;
        $this->positions = $positions;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function getPositions()
    {
        return $this->positions;
    }

    public function setPositions($positions)
    {
        $this->positions = $positions;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
