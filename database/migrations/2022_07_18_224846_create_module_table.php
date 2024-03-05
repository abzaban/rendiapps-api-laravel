<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleTable extends Migration
{
    public function up()
    {
        Schema::create(
            'module',
            function (Blueprint $collection) {
                $collection->id();
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id',
                            'name',
                            'description',
                            'image'
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            '_id' => [
                                'bsonType' => 'objectId'
                            ],
                            'name' => [
                                'bsonType' => 'string'
                            ],
                            'description' => [
                                'bsonType' => 'string'
                            ],
                            'image' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'uri' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'isMaintenance' => [
                                'bsonType' => 'bool'
                            ],
                            'roles' => [
                                'items' => [
                                    [
                                        'bsonType' => 'object',
                                        'additionalProperties' => false,
                                        'properties' => [
                                            '_id' => [
                                                'bsonType' => 'int'
                                            ],
                                            'name' => [
                                                'bsonType' => 'string'
                                            ],
                                            'subModules' => [
                                                'items' => [
                                                    'bsonType' => 'object',
                                                    'additionalProperties' => false,
                                                    'properties' => [
                                                        'name' => [
                                                            'bsonType' => 'string'
                                                        ],
                                                        'description' => [
                                                            'bsonType' => 'string'
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('module');
    }
}
