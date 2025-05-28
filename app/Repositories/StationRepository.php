<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class StationRepository
{
    public function save($townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment, $stationNumber, $brand, $legalPermission, $timestamp)
    {
        return DB::collection('station')->insert([
            'townId' => $townId,
            'businessName' => $businessName,
            'nickName' => $nickName,
            'rfc' => $rfc,
            'email' => $email,
            'cellphones' => $cellphones,
            'serverDomain' => $serverDomain,
            'category' => $category,
            'segment' => $segment,
            'stationNumber' => $stationNumber,
            'brand' => $brand,
            'legalPermission' => $legalPermission,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'deleted_at' => null
        ]);
    }

    public function getAll()
    {
        return DB::collection('station')->whereNull('deleted_at')->get()->toArray();
    }

    public function update($id, $townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment, $stationNumber, $brand, $legalPermission, $timestamp)
    {
        return DB::collection('station')->where('_id', $id)->whereNull('deleted_at')->update([
            'townId' => $townId,
            'businessName' => $businessName,
            'nickName' => $nickName,
            'rfc' => $rfc,
            'email' => $email,
            'cellphones' => $cellphones,
            'serverDomain' => $serverDomain,
            'category' => $category,
            'segment' => $segment,
            'stationNumber' => $stationNumber,
            'brand' => $brand,
            'legalPermission' => $legalPermission,
            'updated_at' => $timestamp
        ]);
    }

    public function delete($id, $timestamp)
    {
        return DB::collection('station')->where('_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timestamp]);
    }

    public function getTableAdapter()
    {
        return DB::getCollection('station')->aggregate(
            [
                [
                    '$match' => ['deleted_at' => null]
                ],
                [
                    '$lookup' => ['from' => 'town', 'localField' => 'townId', 'foreignField' => '_id', 'as' => 'town']
                ],
                [
                    '$addFields' => ['townName' => ['$first' => '$town.name']],
                ],
                [
                    '$project' => ['townName' => 1, 'businessName' => 1, 'nickName' => 1, 'rfc' => 1, 'email' => 1, 'cellphones' => 1, 'serverDomain' => 1, 'category' => 1, 'segment' => 1, 'stationNumber' => 1, 'brand' => 1, 'legalPermission' => 1]
                ]
            ]
        )->toArray();
    }

    public function get($id)
    {
        return DB::collection('station')->where('_id', $id)->whereNull('deleted_at')->first();
    }

    public function getByIds($ids)
    {
        return DB::collection('station')->where(['_id' => ['$in' => $ids]])->get()->toArray();
    }
}
