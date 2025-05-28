<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Timestamp;

class Users extends Seeder
{
    public function run()
    {
        try {
            $users = json_decode(file_get_contents('resources/json/backups/user.json'));
            foreach ($users as $user) {
                $data = [];
                $user = json_decode(json_encode($user), true);

                foreach ($user as $key => $field) {
                    $data[$key] = $field;
                    if ($key == 'permissions') {
                        for ($i = 0; $i < sizeof(($data[$key]['stations'])); $i++)
                            $data[$key]['stations'][$i] = new ObjectId($data[$key]['stations'][$i]['$oid']);

                        for ($i = 0; $i < sizeof(($data[$key]['enterprises'])); $i++)
                            $data[$key]['enterprises'][$i] = new ObjectId($data[$key]['enterprises'][$i]['$oid']);

                        for ($i = 0; $i < sizeof($data[$key]['modules']); $i++)
                            $data[$key]['modules'][$i]['moduleId'] = new ObjectId($data[$key]['modules'][$i]['moduleId']['$oid']);
                    }
                }
                $data['_id'] = new ObjectId($user['_id']['$oid']);
                $data['created_at'] = new Timestamp(1, $user['created_at']['$timestamp']['t']);
                $data['updated_at'] = new Timestamp(1, $user['updated_at']['$timestamp']['t']);

                $user['deleted_at'] ? $data['deleted_at'] = new Timestamp(1, $user['deleted_at']['$timestamp']['t']) : null;

                DB::collection('user')->insert($data);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
