<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterpriseTable extends Migration
{
    public function up()
    {
        Schema::create(
            'enterprise',
            function (Blueprint $collection) {
                $collection->id();
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id',
                            'rfc'
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            '_id' => [
                                'bsonType' => 'objectId'
                            ],
                            'townId' => [
                                'bsonType' => 'objectId'
                            ],
                            'businessName' => [
                                'bsonType' => 'string'
                            ],
                            'nickName' => [
                                'bsonType' => 'string'
                            ],
                            'rfc' => [
                                'bsonType' => 'string',
                                'minLength' => 12,
                                'maxLength' => 12
                            ],
                            'email' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string',
                                        'pattern' => '^([A-Za-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'cellphones' => [
                                'bsonType' => 'array'
                            ],
                            'serverDomain' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'category' => [
                                'enum' => [
                                    'PROPIA',
                                    'RENTAMOS',
                                    'SOCIOS',
                                    'ADMINISTRAMOS'
                                ]
                            ],
                            'segment' => [
                                'bsonType' => 'int'
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
        Schema::dropIfExists('enterprise');
    }
}
