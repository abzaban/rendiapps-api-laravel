<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateTable extends Migration
{
    public function up()
    {
        Schema::create(
            'state',
            function (Blueprint $collection) {
                $collection->id();
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id',
                            'name'
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            '_id' => [
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
        Schema::dropIfExists('state');
    }
}
