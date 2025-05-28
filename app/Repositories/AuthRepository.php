<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Interfaces\MasterRepository;
use Exception;

class AuthRepository implements MasterRepository
{
    public function query($script)
    {
    }

    public function getUserByCreds($key, $authValue)
    {
        try {
            return DB::collection('usuario')->where($key, $authValue)->whereNull('deleted_at');
        } catch (Exception $e) {
            return null;
        }
    }
}
