<?php

namespace Database\Seeders\Inserts;

use Exception;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Timestamp;

class Collects extends Seeder
{
    public function run()
    {
        try {
            $collects = json_decode(file_get_contents('resources/json/backups/collect.json'));
            foreach ($collects as $collect) {
                $data = [];
                $collect = json_decode(json_encode($collect), true);

                $data = [];
                foreach ($collect as $key => $field) {
                    $data[$key] = $field;
                    if ($key == 'payments') {
                        $data['payments'] = [];

                        foreach ($collect['payments'] as $payment) {
                            foreach ($payment as $paymentKey => $paymentField)
                                $paymentData[$paymentKey] = $paymentField;

                            $paymentData['_id'] = new ObjectId($payment['_id']['$oid']);
                            $paymentData['userId'] = new ObjectId($payment['userId']['$oid']);
                            $paymentData['paymentDate'] = new Timestamp(1, $payment['paymentDate']['$timestamp']['t']);

                            $data['payments'][] = $paymentData;
                        }
                    }
                }

                $data['_id'] = new ObjectId($collect['_id']['$oid']);
                $data['stationCollectId'] = new ObjectId($collect['stationCollectId']['$oid']);
                $data['stationPayId'] = new ObjectId($collect['stationPayId']['$oid']);
                $data['userId'] = new ObjectId($collect['userId']['$oid']);
                $data['debitDate'] = new Timestamp(1, $collect['debitDate']['$timestamp']['t']);
                $data['created_at'] = new Timestamp(1, $collect['created_at']['$timestamp']['t']);

                DB::collection('collect')->insert($data);
            }
        } catch (Exception $e) {
            dd($data);
            dd($e->getMessage());
        }
    }
}
