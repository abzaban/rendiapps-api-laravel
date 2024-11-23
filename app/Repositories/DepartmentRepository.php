<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class DepartmentRepository
{
    public function save($name, $ownerId, $timestamp)
    {
        return DB::collection('department')->insert([
            'name' => $name,
            'ownerId' => $ownerId,
            'positions' => [],
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'deleted_at' => null
        ]);
    }

    public function getAll()
    {
        return DB::collection('department')->whereNull('deleted_at')->get()->toArray();
    }

    public function update($id, $name, $ownerId, $timestamp)
    {
        return DB::collection('department')->where('_id', $id)->whereNull('deleted_at')->update([
            'name' => $name,
            'ownerId' => $ownerId,
            'updated_at' => $timestamp
        ]);
    }

    public function delete($id, $timestamp)
    {
        return DB::collection('department')->where('_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timestamp]);
    }

    public function getTableAdapter()
    {
        return DB::getCollection('department')->aggregate(
            [
                [
                    '$match' => ['deleted_at' => null]
                ],
                [
                    '$lookup' => ['from' => 'station', 'localField' => 'ownerId', 'foreignField' => '_id', 'as' => 'station']
                ],
                [
                    '$lookup' => ['from' => 'enterprise', 'localField' => 'ownerId', 'foreignField' => '_id', 'as' => 'enterprise']
                ],
                [
                    '$addFields' => ['stationNickName' => ['$first' => '$station.nickName'], 'enterpriseNickName' => ['$first' => '$enterprise.nickName']]
                ],
                [
                    '$project' => ['_id' => 1, 'name' => 1, 'stationNickName' => 1, 'enterpriseNickName' => 1]
                ]
            ]
        )->toArray();
    }

    public function get($id)
    {
        return DB::collection('department')->where('_id', $id)->whereNull('deleted_at')->first();
    }
}
