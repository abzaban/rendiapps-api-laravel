<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Timestamp;

class Enterprises extends Seeder
{
    public function run()
    {
        try {
            $enterprises = json_decode(file_get_contents('resources/json/backups/enterprise.json'));
            foreach ($enterprises as $enterprise) {
                $data = [];
                $enterprise = json_decode(json_encode($enterprise), true);

                foreach ($enterprise as $key => $field)
                    $data[$key] = $field;

                $data['_id'] = new ObjectId($enterprise['_id']['$oid']);
                $data['townId'] = new ObjectId($enterprise['townId']['$oid']);
                $data['created_at'] = new Timestamp(1, $enterprise['created_at']['$timestamp']['t']);
                $data['updated_at'] = new Timestamp(1, $enterprise['updated_at']['$timestamp']['t']);

                DB::collection('enterprise')->insert([$data]);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
