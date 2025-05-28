<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class EnterpriseRepository
{
    public function save($townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment, $timestamp)
    {
        return DB::collection('enterprise')->insert([
            'townId' => $townId,
            'businessName' => $businessName,
            'nickName' => $nickName,
            'rfc' => $rfc,
            'email' => $email,
            'cellphones' => $cellphones,
            'serverDomain' => $serverDomain,
            'category' => $category,
            'segment' => $segment,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'deleted_at' => null
        ]);
    }

    public function getAll()
    {
        return DB::collection('enterprise')->whereNull('deleted_at')->get()->toArray();
    }

    public function update($id, $townId, $businessName, $nickName, $rfc, $email, $cellphones, $serverDomain, $category, $segment, $timestamp)
    {
        return DB::collection('enterprise')->where('_id', $id)->whereNull('deleted_at')->update([
            'townId' => $townId,
            'businessName' => $businessName,
            'nickName' => $nickName,
            'rfc' => $rfc,
            'email' => $email,
            'cellphones' => $cellphones,
            'serverDomain' => $serverDomain,
            'category' => $category,
            'segment' => $segment,
            'updated_at' => $timestamp
        ]);
    }

    public function delete($id, $timestamp)
    {
        return DB::collection('enterprise')->where('_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timestamp]);
    }

    public function getTableAdapter()
    {
        return DB::getCollection('enterprise')->aggregate(
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
                    '$project' => ['townName' => 1, 'businessName' => 1, 'nickName' => 1, 'rfc' => 1, 'email' => 1, 'cellphones' => 1, 'serverDomain' => 1, 'category' => 1, 'segment' => 1]
                ]
            ]
        )->toArray();
    }

    public function get($id)
    {
        return DB::collection('enterprise')->where('_id', $id)->whereNull('deleted_at')->first();
    }
}
