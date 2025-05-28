<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TokenRepository
{
    public function registerSessionUser($userId, $timestamp)
    {
        return DB::collection('token')->insert([
            '_id' => $userId,
            'authToken' => null,
            'pwdToken' => null,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'deleted_at' => null
        ]);
    }

    public function updateAuthToken($userId, $token, $timestamp)
    {
        return DB::collection('token')->where('_id', $userId)->whereNull('deleted_at')->update([
            'authToken' => $token,
            'updated_at' => $timestamp
        ]);
    }

    public function updatePwdToken($session, $userId, $token, $timestamp)
    {
        return DB::collection('token')->where('_id', $userId)->whereNull('deleted_at')->update(
            [
                'pwdToken' => $token,
                'updated_at' => $timestamp
            ],
            [
                'session' => $session
            ]
        );
    }

    public function getByUserId($userId)
    {
        return DB::collection('token')->where('_id', $userId)->whereNull('deleted_at')->first();
    }

    public function deleteSessionUser($session, $userId, $timestamp)
    {
        return DB::collection('token')->where('_id', $userId)->whereNull('deleted_at')->update(
            [
                'authToken' => null,
                'pwdToken' => null,
                'deleted_at' => $timestamp
            ],
            [
                'session' => $session
            ]
        );
    }
}
