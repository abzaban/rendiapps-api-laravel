<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;

class States extends Seeder
{
    public function run()
    {
        try {
            $states = json_decode(file_get_contents('resources/json/backups/state.json'));
            foreach ($states as $state) {
                $data = [];
                $state = json_decode(json_encode($state), true);

                foreach ($state as $key => $field)
                    $data[$key] = $field;

                $data['_id'] = new ObjectId($state['_id']['$oid']);

                DB::collection('state')->insert($data);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
