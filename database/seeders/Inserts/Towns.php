<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;

class Towns extends Seeder
{
    public function run()
    {
        try {
            $towns = json_decode(file_get_contents('resources/json/backups/town.json'));
            foreach ($towns as $town) {
                $data = [];
                $town = json_decode(json_encode($town), true);

                foreach ($town as $key => $field)
                    $data[$key] = $field;

                $data['_id'] = new ObjectId($town['_id']['$oid']);
                $data['stateId'] = new ObjectId($town['stateId']['$oid']);

                DB::collection('town')->insert($data);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
