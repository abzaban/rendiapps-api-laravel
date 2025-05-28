<?php

namespace App\Domain;

use JsonSerializable;

class User implements JsonSerializable
{
    private $id, $firstName, $lastName, $address, $email, $image, $username, $password, $permissions;

    function __construct($id, $firstName, $lastName, $address, $email, $image, $username, $password, $permissions)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->email = $email;
        $this->image = $image;
        $this->username = $username;
        $this->password = $password;
        $this->permissions = $permissions;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        unset($vars['password']); // remove the password to don't return the password to client
        return $vars;
    }
}
