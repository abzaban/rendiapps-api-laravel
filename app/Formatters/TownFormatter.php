<?php

namespace App\Formatters;

use App\Domain\Town;

class TownFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data))
            return new Town($this->mongoFormatter->objectIdToStringId($data->_id), $data->name);

        $dataFormatted = [];
        foreach ($data as $town) {
            $town = (object) $town;
            $dataFormatted[] = new Town($this->mongoFormatter->objectIdToStringId($town->_id), $town->name);
        }
        return $dataFormatted;
    }
}
