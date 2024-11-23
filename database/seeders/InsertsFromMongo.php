<?php

namespace Database\Seeders;

use Database\Seeders\Inserts\Collects;
use Illuminate\Database\Seeder;

use Database\Seeders\Inserts\States;
use Database\Seeders\Inserts\Towns;
use Database\Seeders\Inserts\Modules;
use Database\Seeders\Inserts\Stations;
use Database\Seeders\Inserts\Enterprises;
use Database\Seeders\Inserts\Users;
use Database\Seeders\Inserts\Tokens;


class InsertsFromMongo extends Seeder
{
    public function run()
    {
        $this->call([
            States::class,
            Towns::class,
            Modules::class,
            Stations::class,
            Enterprises::class,
            Users::class,
            Tokens::class,
            Collects::class
        ]);
    }
}
