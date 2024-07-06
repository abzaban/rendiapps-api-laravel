<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTable extends Migration
{
    public function up()
    {
        Schema::create(
            'department',
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
                            ],
                            'ownerId' => [
                                'bsonType' => 'objectId'
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
                            'positions' => [
                                'items' => [
                                    [
                                        'bsonType' => 'object',
                                        'additionalProperties' => false,
                                        'properties' => [
                                            '_id' => [
                                                'bsonType' => 'objectId'
                                            ],
                                            'name' => [
                                                'bsonType' => 'objectId'
                                            ],
                                            'dailySalary' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'double'
                                                    ],
                                                    [
                                                        'bsonType' => 'int'
                                                    ]
                                                ]
                                            ],
                                            'dailySalaryIntegrated' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'double'
                                                    ],
                                                    [
                                                        'bsonType' => 'int'
                                                    ]
                                                ]
                                            ],
                                            'punctualityBonus' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'double'
                                                    ],
                                                    [
                                                        'bsonType' => 'int'
                                                    ]
                                                ]
                                            ],
                                            'attendanceBonus' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'double'
                                                    ],
                                                    [
                                                        'bsonType' => 'int'
                                                    ]
                                                ]
                                            ],
                                            'pantry' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'double'
                                                    ],
                                                    [
                                                        'bsonType' => 'int'
                                                    ]
                                                ]
                                            ],
                                            'monthlyNetSalary' => [
                                                'oneOf' => [
                                                    [
                                                        'bsonType' => 'double'
                                                    ],
                                                    [
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
                ]
            ]
        );
    }

    public function down()
    {
        Schema::dropIfExists('department');
    }
}
