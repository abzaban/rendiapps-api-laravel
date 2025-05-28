<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownTable extends Migration
{
    public function up()
    {
        Schema::create(
            'town',
            function (Blueprint $collection) {
                $collection->id();
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id',
                            'stateId',
                            'name'
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            '_id' => [
                                'bsonType' => 'objectId'
                            ],
                            'stateId' => [
                                'bsonType' => 'objectId'
                            ],
                            'name' => [
                                'bsonType' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('town');
    }
}
