<?php

namespace App\Models;

use App\Repositories\DepartmentRepository;

use App\Formatters\DepartmentFormatter;
use App\Formatters\MongoDBFormatter;

class DepartmentModel
{
    private $departmentRepository, $departmentFormatter, $mongoFormatter;

    function __construct()
    {
        $this->departmentRepository = new DepartmentRepository();
        $this->departmentFormatter = new DepartmentFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function save($name, $ownerId)
    {
        return $this->departmentRepository->save(
            $name,
            $this->mongoFormatter->stringIdToObjectId($ownerId),
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function getAll()
    {
        return $this->departmentFormatter->toDomain($this->departmentRepository->getAll());
    }

    public function update($id, $name, $ownerId)
    {
        return $this->departmentRepository->update(
            $this->mongoFormatter->stringIdToObjectId($id),
            $name,
            $this->mongoFormatter->stringIdToObjectId($ownerId),
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function delete($id)
    {
        return $this->departmentRepository->delete($this->mongoFormatter->stringIdToObjectId($id), $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function getTableAdapter()
    {
        return $this->departmentFormatter->toTable($this->departmentRepository->getTableAdapter());
    }

    public function get($id)
    {
        $department = $this->departmentRepository->get($this->mongoFormatter->stringIdToObjectId($id));
        return $department ? $this->departmentFormatter->toDomain((object) $department) : null;
    }
}
