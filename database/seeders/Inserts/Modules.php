<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;

class Modules extends Seeder
{
    public function run()
    {
        try {
            $modules = json_decode(file_get_contents('resources/json/backups/module.json'));
            foreach ($modules as $module) {
                $data = [];
                $module = json_decode(json_encode($module), true);

                foreach ($module as $key => $field)
                    $data[$key] = $field;

                $data['_id'] = new ObjectId($module['_id']['$oid']);

                DB::collection('module')->insert($data);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
