<?php

namespace App\Formatters;

use App\Domain\Station;

use App\Adapters\StationTableAdapter;

class StationFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data))
            return new Station(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $this->mongoFormatter->objectIdToStringId($data->townId),
                $data->businessName,
                $data->nickName,
                $data->rfc,
                $data->email,
                $data->cellphones,
                $data->serverDomain,
                $data->category,
                $data->segment,
                $data->stationNumber,
                $data->brand,
                $data->legalPermission
            );

        $dataFormatted = [];
        foreach ($data as $station) {
            $station = (object) $station;
            $dataFormatted[] = new Station(
                $this->mongoFormatter->objectIdToStringId($station->_id),
                $this->mongoFormatter->objectIdToStringId($station->townId),
                $station->businessName,
                $station->nickName,
                $station->rfc,
                $station->email,
                $station->cellphones,
                $station->serverDomain,
                $station->category,
                $station->segment,
                $station->stationNumber,
                $station->brand,
                $station->legalPermission
            );
        }
        return $dataFormatted;
    }

    public function toTable($data)
    {
        if (!is_array($data))
            return new StationTableAdapter(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->townName,
                $data->businessName,
                $data->nickName,
                $data->rfc,
                $data->email,
                $data->cellphones,
                $data->serverDomain,
                $data->category,
                $data->segment,
                $data->stationNumber,
                $data->brand,
                $data->legalPermission
            );

        $dataFormatted = [];
        foreach ($data as $station) {
            $station = (object) $station;
            $dataFormatted[] = new StationTableAdapter(
                $this->mongoFormatter->objectIdToStringId($station->_id),
                $station->townName,
                $station->businessName,
                $station->nickName,
                $station->rfc,
                $station->email,
                $station->cellphones,
                $station->serverDomain,
                $station->category,
                $station->segment,
                $station->stationNumber,
                $station->brand,
                $station->legalPermission
            );
        }
        return $dataFormatted;
    }
}
