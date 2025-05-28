<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TownRepository
{
    public function getAll()
    {
        return DB::collection('town')->get()->toArray();
    }
}
