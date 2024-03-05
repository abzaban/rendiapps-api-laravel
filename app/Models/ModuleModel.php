<?php

namespace App\Models;

use App\Repositories\ModuleRepository;

use App\Formatters\ModuleFormatter;
use App\Formatters\MongoDBFormatter;

class ModuleModel
{
    private $moduleRepository, $moduleFormatter, $mongoFormatter;

    function __construct()
    {
        $this->moduleRepository = new ModuleRepository();
        $this->moduleFormatter = new ModuleFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function getAll()
    {
        $modules = $this->moduleRepository->getAll();
        return $modules ? $this->moduleFormatter->toDomain($modules) : null;
    }

    public function getByIds($ids)
    {
        $modules = $this->moduleRepository->getByIds($this->mongoFormatter->stringIdsToObjectIds($ids));
        return $modules ? $this->moduleFormatter->toDomain($modules) : null;
    }
}
