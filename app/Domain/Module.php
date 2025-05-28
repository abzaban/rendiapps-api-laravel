<?php

namespace App\Domain;

use JsonSerializable;

class Module implements JsonSerializable
{
    private $id, $name, $description, $image, $uri, $isMaintenance, $roles;

    function __construct($id, $name, $description, $image, $uri, $isMaintenance, $roles)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->uri = $uri;
        $this->isMaintenance = $isMaintenance;
        $this->roles = [];
        if ($roles)
            foreach ($roles as $rol) {
                $rol = (object) $rol;
                $this->roles[] = new Rol($rol->_id, $rol->name, $rol->subModules);
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getIsMaintenance()
    {
        return $this->isMaintenance;
    }

    public function setIsMaintenance($isMaintenance)
    {
        $this->isMaintenance = $isMaintenance;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
