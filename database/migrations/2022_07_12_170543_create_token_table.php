<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenTable extends Migration
{
    public function up()
    {
        Schema::create(
            'token',
            function (Blueprint $collection) {
                $collection->id();
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id'
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            '_id' => [
                                'bsonType' => 'objectId',
                                'description' => 'id del usuario'
                            ],
                            'authToken' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string',
                                    ],
                                    [
                                        'bsonType' => 'null',
                                    ]
                                ],
                                'description' => 'token que indica la sesion del usuario'
                            ],
                            'pwdToken' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string',
                                    ],
                                    [
                                        'bsonType' => 'null',
                                    ]
                                ],
                                'description' => 'token que inidica si el usuario esta en proceso de recuperacion de password'
                            ],
                            'created_at' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'timestamp'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'updated_at' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'timestamp'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'deleted_at' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'timestamp'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'validationLevel' => 'strict',
                'validationAction' => 'error'
            ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('token');
    }
};
