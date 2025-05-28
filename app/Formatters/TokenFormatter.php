<?php

namespace App\Formatters;

use App\Domain\Token;

class TokenFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data))
            return new Token($this->mongoFormatter->objectIdToStringId($data->_id), $data->authToken, $data->pwdToken);

        $dataFormated = [];
        foreach ($data as $tokenEntity)
            $dataFormated[] = new Token($this->mongoFormatter->objectIdToStringId($tokenEntity->_id), $tokenEntity->authToken, $tokenEntity->pwdToken);
        return $dataFormated;
    }
}
