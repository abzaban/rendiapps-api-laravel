<?php

namespace App\Models;

use App\Repositories\TownRepository;

use App\Formatters\TownFormatter;

class TownModel
{
    private $townRepository, $townFormatter;

    function __construct()
    {
        $this->townRepository = new TownRepository();
        $this->townFormatter = new TownFormatter;
    }

    public function getAll()
    {
        return $this->townFormatter->toDomain($this->townRepository->getAll());
    }
}
