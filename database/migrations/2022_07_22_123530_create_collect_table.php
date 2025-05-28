<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectTable extends Migration
{
    public function up()
    {
        Schema::create(
            'collect',
            function (Blueprint $table) {
                $table->id();
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id',
                            'stationCollectId',
                            'stationPayId',
                            'userId',
                            'status',
                            'amount'
                        ],
                        'additionalProperties' => true,
                        'properties' => [
                            '_id' => [
                                'bsonType' => 'objectId'
                            ],
                            'stationCollectId' => [
                                'bsonType' => 'objectId'
                            ],
                            'stationPayId' => [
                                'bsonType' => 'objectId'
                            ],
                            'userId' => [
                                'bsonType' => 'objectId'
                            ],
                            'status' => [
                                'enum' => [
                                    'PENDIENTE',
                                    'AUTORIZADA',
                                    'ABONADA',
                                    'PAGADA',
                                    'RECHAZADA'
                                ]
                            ],
                            'amount' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'double'
                                    ],
                                    [
                                        'bsonType' => 'int'
                                    ]
                                ]
                            ],
                            'file' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'rejectedNote' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'string'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
                            ],
                            'debitDate' => [
                                'oneOf' => [
                                    [
                                        'bsonType' => 'timestamp'
                                    ],
                                    [
                                        'bsonType' => 'null'
                                    ]
                                ]
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
                            'payments' => [
                                'items' => [
                                    [
                                        'bsonType' => 'object',
                                        'additionalProperties' => false,
                                        'properties' => [
                                            '_id' => [
                                                'bsonType' => 'objectId'
                                            ],
                                            'userId' => [
                                                'bsonType' => 'objectId'
                                            ],
                                            'amount' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'double'
                                                    ],
                                                    [
                                                        'bsonType' => 'int'
                                                    ]
                                                ]
                                            ],
                                            'file' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'string'
                                                    ],
                                                    [
                                                        'bsonType' => 'null'
                                                    ]
                                                ]
                                            ],
                                            'paymentDate' => [
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
        Schema::dropIfExists('collect');
    }
}
