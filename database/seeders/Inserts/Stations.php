<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Timestamp;

class Stations extends Seeder
{
    public function run()
    {
        try {
            $stations = json_decode(file_get_contents('resources/json/backups/station.json'));
            foreach ($stations as $station) {
                $data = [];
                $station = json_decode(json_encode($station), true);

                foreach ($station as $key => $field)
                    $data[$key] = $field;

                $data['_id'] = new ObjectId($station['_id']['$oid']);
                $data['townId'] = new ObjectId($station['townId']['$oid']);
                $data['created_at'] = new Timestamp(1, $station['created_at']['$timestamp']['t']);
                $data['updated_at'] = new Timestamp(1, $station['updated_at']['$timestamp']['t']);

                DB::collection('station')->insert([$data]);
            }
        } catch (Exception $e) {
            dd($data);
            dd($e->getMessage());
        }
    }
}
