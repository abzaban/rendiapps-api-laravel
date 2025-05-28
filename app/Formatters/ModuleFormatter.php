<?php

namespace App\Formatters;

use App\Domain\Module;

class ModuleFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data))
            return new Module(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->name,
                $data->description,
                $data->image,
                $data->uri,
                $data->isMaintenance,
                $data->roles
            );

        $dataFormatted = [];
        foreach ($data as $module) {
            $module = (object) $module;
            $dataFormatted[] = new Module(
                $this->mongoFormatter->objectIdToStringId($module->_id),
                $module->name,
                $module->description,
                $module->image,
                $module->uri,
                $module->isMaintenance,
                $module->roles
            );
        }
        return $dataFormatted;
    }
}
