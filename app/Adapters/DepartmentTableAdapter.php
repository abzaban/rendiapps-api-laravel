<?php

namespace App\Adapters;

use JsonSerializable;

class DepartmentTableAdapter implements JsonSerializable
{
    private $id, $name, $ownerNickName;

    function __construct($id, $name, $ownerNickName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ownerNickName = $ownerNickName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getOwnerNickName()
    {
        return $this->ownerNickName;
    }

    public function setOwnerNickName($ownerNickName)
    {
        $this->ownerNickName = $ownerNickName;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
