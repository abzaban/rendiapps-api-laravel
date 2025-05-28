<?php

namespace App\Models;

use App\Repositories\EnterpriseRepository;

use App\Formatters\EnterpriseFormatter;
use App\Formatters\MongoDBFormatter;

class EnterpriseModel
{
    private $enterpriseRepository, $enterpriseFormatter, $mongoFormatter;

    function __construct()
    {
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->enterpriseFormatter = new EnterpriseFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function save($townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment)
    {
        return $this->enterpriseRepository->save(
            $this->mongoFormatter->stringIdToObjectId($townId),
            $businessName,
            $nickName,
            $rfc,
            $email,
            $cellphones,
            $serverDomain,
            $category,
            $segment,
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function getAll()
    {
        return $this->enterpriseFormatter->toDomain($this->enterpriseRepository->getAll());
    }

    public function update($id, $townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment)
    {
        return $this->enterpriseRepository->update(
            $this->mongoFormatter->stringIdToObjectId($id),
            $this->mongoFormatter->stringIdToObjectId($townId),
            $businessName,
            $nickName,
            $rfc,
            $email,
            $cellphones,
            $serverDomain,
            $category,
            $segment,
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function delete($id)
    {
        return $this->enterpriseRepository->delete($this->mongoFormatter->stringIdToObjectId($id), $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function getTableAdapter()
    {
        return $this->enterpriseFormatter->toTable($this->enterpriseRepository->getTableAdapter());
    }

    public function get($id)
    {
        $enterprise = $this->enterpriseRepository->get($this->mongoFormatter->stringIdToObjectId($id));
        return $enterprise ? $this->enterpriseFormatter->toDomain((object) $enterprise) : null;
    }
}
