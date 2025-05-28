<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    public function up()
    {
        Schema::create(
            'user',
            function (Blueprint $collection) {
                $collection->id();
                $collection->string('email')->unique();
                $collection->string('username')->unique();
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id',
                            'firstName',
                            'lastName',
                            'address',
                            'email',
                            'image',
                            'username',
                            'password'
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            '_id' => [
                                'bsonType' => 'objectId'
                            ],
                            'firstName' => [
                                'bsonType' => 'string'
                            ],
                            'lastName' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'address' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
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
                            'email' => [
                                'pattern' => '^([A-Za-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$'
                            ],
                            'username' => [
                                'bsonType' => 'string',
                                'minLength' => 4
                            ],
                            'password' => [
                                'bsonType' => 'string',
                                'minLength' => 6
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
                            ],
                            'permissions' => [
                                'bsonType' => 'object',
                                'properties' => [
                                    'enterprises' => [
                                        'items' => [
                                            [
                                                'bsonType' => 'objectId'
                                            ]
                                        ]
                                    ],
                                    'stations' => [
                                        'items' => [
                                            [
                                                'bsonType' => 'objectId'
                                            ]
                                        ]
                                    ],
                                    'modules' => [
                                        'items' => [
                                            [
                                                'bsonType' => 'object',
                                                'additionalProperties' => false,
                                                'properties' => [
                                                    'moduleId' => [
                                                        'bsonType' => 'objectId'
                                                    ],
                                                    'roleId' => [
                                                        'bsonType' => 'int'
                                                    ]
                                                ]
                                            ]
                                        ]
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
        Schema::dropIfExists('user');
    }
};
