<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ModuleRepository
{
    public function getAll()
    {
        return DB::collection('module')->get()->toArray();
    }

    public function getByIds($ids)
    {
        return DB::collection('module')->where(['_id' => ['$in' => $ids]])->orderBy('name', 'asc')->get()->toArray();
    }
}
