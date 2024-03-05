<?php

namespace App\Models;

use App\Repositories\StationRepository;

use App\Formatters\StationFormatter;
use App\Formatters\MongoDBFormatter;

class StationModel
{
    private $stationRepository, $stationFormatter, $mongoFormatter;

    function __construct()
    {
        $this->stationRepository = new StationRepository();
        $this->stationFormatter = new StationFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function save($townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment, $stationNumber, $brand, $legalPermission)
    {
        return $this->stationRepository->save(
            $this->mongoFormatter->stringIdToObjectId($townId),
            $businessName,
            $nickName,
            $rfc,
            $email,
            $cellphones,
            $serverDomain,
            $category,
            $segment,
            $stationNumber,
            $brand,
            $legalPermission,
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function getAll()
    {
        return $this->stationFormatter->toDomain($this->stationRepository->getAll());
    }

    public function update($id, $townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment, $stationNumber, $brand, $legalPermission)
    {
        return $this->stationRepository->update(
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
            $stationNumber,
            $brand,
            $legalPermission,
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function delete($id)
    {
        return $this->stationRepository->delete($this->mongoFormatter->stringIdToObjectId($id), $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function getTableAdapter()
    {
        return $this->stationFormatter->toTable($this->stationRepository->getTableAdapter());
    }

    public function get($id)
    {
        $station = $this->stationRepository->get($this->mongoFormatter->stringIdToObjectId($id));
        return $station ? $this->stationFormatter->toDomain((object) $station) : null;
    }

    public function getByIds($ids)
    {
        return $this->stationFormatter->toDomain($this->stationRepository->getByIds($ids));
    }
}
