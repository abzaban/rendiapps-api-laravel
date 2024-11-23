<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class WalletRepository
{
    public function create($id, $account)
    {
        return DB::collection('wallet')->insert(['_id' => $id, 'accounts' => [$account]]);
    }

    public function get($id)
    {
        return DB::collection('wallet')->where('_id', $id)->first();
    }

    public function getTableAdapterOfWallets()
    {
        return DB::getCollection('wallet')->aggregate(
            [
                [
                    '$lookup' => ['from' => 'station', 'localField' => '_id', 'foreignField' => '_id', 'as' => 'station']
                ],
                [
                    '$lookup' => ['from' => 'enterprise', 'localField' => '_id', 'foreignField' => '_id', 'as' => 'enterprise']
                ],
                [
                    '$addFields' => ['stationNickName' => ['$first' => '$station.nickName'], 'enterpriseNickName' => ['$first' => '$enterprise.nickName']]
                ],
                [
                    '$project' => ['_id' => 1, 'stationNickName' => 1, 'enterpriseNickName' => 1, 'accounts' => 1]
                ]
            ]
        )->toArray();
    }

    public function addAccount($id, $accountId, $bankName, $accountNumber)
    {
        return DB::collection('wallet')->where('_id', $id)->update([
            '$push' => [
                'accounts' => [
                    '_id' => $accountId,
                    'bankName' => $bankName,
                    'accountNumber' => $accountNumber,
                    'balances' => []
                ]
            ]
        ]);
    }

    public function updateAccount($id, $accountId, $bankName, $accountNumber)
    {
        return DB::collection('wallet')->where('_id', $id)->where('accounts._id', $accountId)->update([
            '$set' => [
                'accounts.$.bankName' => $bankName,
                'accounts.$.accountNumber' => $accountNumber
            ]
        ]);
    }

    public function deleteAccount($id, $accountId)
    {
        return DB::collection('wallet')->where('_id', $id)->update(['$pull' => ['accounts' => ['_id' => $accountId]]]);
    }

    public function addBalance($id, $accountId, $balanceId, $asset, $created_at)
    {
        return DB::collection('wallet')->where('_id', $id)->where('accounts._id', $accountId)->update([
            '$push' => [
                'accounts.$.balances' => [
                    '_id' => $balanceId,
                    'asset' => $asset,
                    'created_at' => $created_at
                ]
            ]
        ]);
    }

    public function updateBalance($id, $accountId, $balanceId, $asset)
    {
        return DB::collection('wallet')->where('_id', $id)->update(
            [
                '$set' => ['accounts.$[i].balances.$[j].asset' => $asset]
            ],
            [
                'arrayFilters' => [
                    ["i._id" => $accountId],
                    ["j._id" => $balanceId]
                ]
            ]
        );
    }

    public function deleteBalance($id, $accountId, $balanceId)
    {
        return DB::collection('wallet')->where('_id', $id)->where('accounts._id', $accountId)->update([
            '$pull' => [
                'accounts.$.balances' => ['_id' => $balanceId]
            ]
        ]);
    }
}
