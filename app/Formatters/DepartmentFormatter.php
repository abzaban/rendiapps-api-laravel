<?php

namespace App\Formatters;

use App\Domain\Department;

use App\Adapters\DepartmentTableAdapter;

class departmentFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data))
            return new Department(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->name,
                $this->mongoFormatter->objectIdToStringId($data->ownerId),
                $data->positions
            );

        $dataFormatted = [];
        foreach ($data as $department) {
            $department = (object) $department;
            $dataFormatted[] = new Department(
                $this->mongoFormatter->objectIdToStringId($department->_id),
                $department->name,
                $this->mongoFormatter->objectIdToStringId($department->ownerId),
                $department->positions
            );
        }
        return $dataFormatted;
    }

    public function toTable($data)
    {
        if (!is_array($data))
            return new DepartmentTableAdapter(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->name,
                property_exists($data, 'stationNickName') ? $data->stationNickName : $data->enterpriseNickName
            );

        $dataFormatted = [];
        foreach ($data as $department) {
            $department = (object) $department;
            $dataFormatted[] = new DepartmentTableAdapter(
                $this->mongoFormatter->objectIdToStringId($department->_id),
                $department->name,
                property_exists($department, 'stationNickName') ? $department->stationNickName : $department->enterpriseNickName
            );
        }
        return $dataFormatted;
    }
}
