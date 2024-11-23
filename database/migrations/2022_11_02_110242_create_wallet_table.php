<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTable extends Migration
{
    public function up()
    {
        Schema::create(
            'wallet',
            function (Blueprint $collection) {
            },
            [
                'validator' => [
                    '$jsonSchema' => [
                        'bsonType' => 'object',
                        'required' => [
                            '_id',
                            'accounts'
                        ],
                        'additionalProperties' => false,
                        'properties' => [
                            '_id' => [
                                'bsonType' => 'objectId'
                            ],
                            'accounts' => [
                                'items' => [
                                    [
                                        'bsonType' => 'object',
                                        'additionalProperties' => false,
                                        'properties' => [
                                            '_id' => [
                                                'bsonType' => 'objectId'
                                            ],
                                            'bankName' => [
                                                'enum' => [
                                                    'BANORTE',
                                                    'BBVA',
                                                    'SANTANDER',
                                                    'INBURSA',
                                                    'BAJIO',
                                                    'AZTECA',
                                                    'SCOTIABANK',
                                                    'BANREGIO'
                                                ]
                                            ],
                                            'accountNumber' => [
                                                'bsonType' => 'string',
                                                'minLength' => 14,
                                                'maxLength' => 19
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
                                            'balances' => [
                                                'items' => [
                                                    'bsonType' => 'object',
                                                    'additionalProperties' => false,
                                                    'properties' => [
                                                        '_id' => [
                                                            'bsonType' => 'objectId'
                                                        ],
                                                        'asset' => [
                                                            'oneOf' => [
                                                                [
                                                                    'bsonType' => 'double'
                                                                ],
                                                                [
                                                                    'bsonType' => 'int'
                                                                ]
                                                            ]
                                                        ],
                                                        'created_at' => [
                                                            'bsonType' => 'timestamp'
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
                ],
                'validationLevel' => 'strict',
                'validationAction' => 'error'
            ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('wallet');
    }
}
