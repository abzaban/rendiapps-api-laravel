<?php

namespace App\Domain;

use JsonSerializable;

class Rol implements JsonSerializable
{
    private $id, $name, $subModules;

    function __construct($id, $name, $subModules)
    {
        $this->id = $id;
        $this->name = $name;
        $this->subModules = [];
        if ($subModules)
            foreach ($subModules as $subModule) {
                $subModule = (object) $subModule;
                $this->subModules[] = new SubModule($subModule->name, $subModule->description);
            }
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

    public function getSubModules()
    {
        return $this->subModules;
    }

    public function setSubModules($subModules)
    {
        $this->subModules = $subModules;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
