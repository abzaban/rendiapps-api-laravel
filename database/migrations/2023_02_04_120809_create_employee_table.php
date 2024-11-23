<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    public function up()
    {
        Schema::create(
            'employee',
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
                                'bsonType' => 'objectId'
                            ],
                            'name' => [
                                'bsonType' => 'string'
                            ],
                            'fatherLastName' => [
                                'bsonType' => 'string'
                            ],
                            'motherLastName' => [
                                'bsonType' => 'string'
                            ],
                            'address' => [
                                'bsonType' => 'string'
                            ],
                            'gender' => [
                                'enum' => [
                                    'MASCULINO',
                                    'FEMENINO',
                                    'INDISTINTO'
                                ]
                            ],
                            'cellphone' => [
                                'bsonType' => 'string',
                                'maxLength' => 10
                            ],
                            'email' => [
                                'pattern' => '^([A-Za-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$'
                            ],
                            'birthDate' => [
                                'bsonType' => 'timestamp',
                            ],
                            'emergencyContactName' => [
                                'bsonType' => 'string',
                            ],
                            'emergencyContactCellphone' => [
                                'bsonType' => 'string',
                                'maxLength' => 10
                            ],
                            'rfc' => [
                                'bsonType' => 'string'
                            ],
                            'curp' => [
                                'bsonType' => 'string'
                            ],
                            'nss' => [
                                'bsonType' => 'string'
                            ],
                            'psychometry' => [
                                'bsonType' => 'bool'
                            ],
                            'maritalStatus' => [
                                'enum' => [
                                    'CASADO',
                                    'SOLTERO',
                                    'UNION LIBRE'
                                ]
                            ],
                            'matrimonialRegime' => [
                                'enum' => [
                                    'BIENES PRIVATIVOS',
                                    'BIENES COMUNES',
                                    'BIEN MANCOMUNADOS',
                                    'BIENES SEPARADOS',
                                    'INDISTINTO',
                                    'POR DEFINIR'
                                ]
                            ],
                            'educationLevel' => [
                                'enum' => [
                                    'PRIMARIA',
                                    'SECUNDARIA',
                                    'BACHILLERATO',
                                    'SUPERIOR'
                                ]
                            ],
                            'admissionDate' => [
                                'bsonType' => 'timestamp',
                            ],
                            'image' => [
                                'bsonType' => 'string',
                            ],
                            'jobPositionId' => [
                                'bsonType' => 'objectId'
                            ],
                            'nationalityId' => [
                                'bsonType' => 'objectId'
                            ],
                            'companyId' => [
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
                            'benefits' => [
                                'bsonType' => 'object',
                                'properties' => [
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
                                    ],
                                    'accountNumber' => [
                                        'bsonType' => 'string'
                                    ],
                                    'infonavitCreditNumber' => [
                                        'bsonType' => 'string'
                                    ]
                                ]
                            ],
                            'beneficiary' => [
                                'bsonType' => 'object',
                                'properties' => [
                                    'name' => [
                                        'bsonType' => 'string'
                                    ],
                                    'fatherLastName' => [
                                        'bsonType' => 'string'
                                    ],
                                    'motherLastName' => [
                                        'bsonType' => 'string'
                                    ],
                                    'address' => [
                                        'bsonType' => 'string'
                                    ],
                                    'birthDate' => [
                                        'bsonType' => 'timestamp'
                                    ],
                                    'rfc' => [
                                        'bsonType' => 'string'
                                    ],
                                    'familyRelathionship' => [
                                        'bsonType' => 'string'
                                    ]
                                ]
                            ],
                            'left' => [
                                'bsonType' => 'object',
                                'properties' => [
                                    'reason' => [
                                        'bsonType' => 'string'
                                    ],
                                    'observations' => [
                                        'bsonType' => 'string'
                                    ],
                                    'leftDate' => [
                                        'bsonType' => 'timestamp'
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
        Schema::dropIfExists('employee');
    }
}
