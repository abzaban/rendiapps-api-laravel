<?php

namespace App\Formatters;

use App\Domain\Enterprise;

use App\Adapters\EnterpriseTableAdapter;

class EnterpriseFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data))
            return new Enterprise(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $this->mongoFormatter->objectIdToStringId($data->townId),
                $data->businessName,
                $data->nickName,
                $data->rfc,
                $data->email,
                $data->cellphones,
                $data->serverDomain,
                $data->category,
                $data->segment
            );

        $dataFormatted = [];
        foreach ($data as $enterprise) {
            $enterprise = (object) $enterprise;
            $dataFormatted[] = new Enterprise(
                $this->mongoFormatter->objectIdToStringId($enterprise->_id),
                $this->mongoFormatter->objectIdToStringId($enterprise->townId),
                $enterprise->businessName,
                $enterprise->nickName,
                $enterprise->rfc,
                $enterprise->email,
                $enterprise->cellphones,
                $enterprise->serverDomain,
                $enterprise->category,
                $enterprise->segment
            );
        }
        return $dataFormatted;
    }

    public function toTable($data)
    {
        if (!is_array($data))
            return new EnterpriseTableAdapter(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->townName,
                $data->businessName,
                $data->nickName,
                $data->rfc,
                $data->email,
                $data->cellphones,
                $data->serverDomain,
                $data->category,
                $data->segment
            );

        $dataFormatted = [];
        foreach ($data as $enterprise) {
            $enterprise = (object) $enterprise;
            $dataFormatted[] = new EnterpriseTableAdapter(
                $this->mongoFormatter->objectIdToStringId($enterprise->_id),
                $enterprise->townName,
                $enterprise->businessName,
                $enterprise->nickName,
                $enterprise->rfc,
                $enterprise->email,
                $enterprise->cellphones,
                $enterprise->serverDomain,
                $enterprise->category,
                $enterprise->segment
            );
        }
        return $dataFormatted;
    }
}
