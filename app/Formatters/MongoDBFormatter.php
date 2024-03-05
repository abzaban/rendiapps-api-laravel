<?php

namespace App\Formatters;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Timestamp;
use MongoDB\Model\BSONDocument;

class MongoDBFormatter
{
    public function newObjectId()
    {
        return new ObjectId();
    }

    public function stringIdToObjectId($id)
    {
        return new ObjectId($id);
    }

    public function objectIdToStringId($id)
    {
        return $id->__toString();
    }

    public function stringIdsToObjectIds($ids)
    {
        $idsFormated = [];
        foreach ($ids as $id)
            $idsFormated[] = new ObjectId($id);

        return $idsFormated;
    }

    public function objectIdsToStringIds($ids)
    {
        $idsFormated = [];
        foreach ($ids as $id)
            $idsFormated[] = $id->__toString();

        return $idsFormated;
    }

    public function stringDateToTimestamp($date)
    {
        return new Timestamp(1, strtotime($date));
    }

    public function timestampToStringDate($timestamp)
    {
        return date('d/m/Y', $timestamp->getTimestamp());
    }

    public function arrayToBsonDocument($array) {
        return new BSONDocument($array);
    }
}
