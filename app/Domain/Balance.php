<?php

namespace App\Domain;

use JsonSerializable;

class Balance implements JsonSerializable
{
    private $id, $asset, $created_at;

    function __construct($id, $asset, $created_at)
    {
        $this->id = $id;
        $this->asset = $asset;
        $this->created_at = $created_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAsset()
    {
        return $this->asset;
    }

    public function setAsset($asset)
    {
        $this->asset = $asset;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
