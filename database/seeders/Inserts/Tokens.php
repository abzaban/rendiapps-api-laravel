<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Timestamp;

class Tokens extends Seeder
{
    public function run()
    {
        try {
            $tokens = json_decode(file_get_contents('resources/json/backups/token.json'));
            foreach ($tokens as $token) {
                $data = [];
                $token = json_decode(json_encode($token), true);

                foreach ($token as $key => $field)
                    $data[$key] = $field;

                $data['_id'] = new ObjectId($token['_id']['$oid']);
                $data['created_at'] = new Timestamp(1, $token['created_at']['$timestamp']['t']);
                $data['updated_at'] = new Timestamp(1, $token['updated_at']['$timestamp']['t']);

                DB::collection('token')->insert($data);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
