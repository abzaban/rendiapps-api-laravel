<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CollectRepository
{
    public function save($stationCollectId, $stationPayId, $userId, $amount, $debitDate, $timestamp)
    {
        return DB::collection('collect')->insertGetId([
            'stationCollectId' => $stationCollectId,
            'stationPayId' => $stationPayId,
            'userId' => $userId,
            'status' => 'PENDIENTE',
            'amount' => $amount,
            'file' => null,
            'rejectedNote' => null,
            'debitDate' => $debitDate,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'deleted_at' => null,
            'payments' => []
        ]);
    }

    public function delete($id, $timestamp)
    {
        return DB::collection('collect')->where('_id', $id)->whereNull('deleted_at')->update(['deleted_at' => $timestamp]);
    }

    public function get($id)
    {
        return DB::collection('collect')->where('_id', $id)->whereNull('deleted_at')->first();
    }

    public function updateFile($id, $file)
    {
        return DB::collection('collect')->where('_id', $id)->whereNull('deleted_at')->update(['file' => $file]);
    }

    public function getTableAdapterOfCollectsToCollectInDateRange($stationsIds, $startDate, $endDate)
    {
        return DB::getCollection('collect')->aggregate(
            [
                [
                    '$match' => ['deleted_at' => null, 'stationCollectId' => ['$in' => $stationsIds], 'debitDate' => ['$gte' => $startDate, '$lte' => $endDate]]
                ],
                [
                    '$lookup' => ['from' => 'station', 'localField' => 'stationCollectId', 'foreignField' => '_id', 'as' => 'stationCollect']
                ],
                [
                    '$lookup' => ['from' => 'station', 'localField' => 'stationPayId', 'foreignField' => '_id', 'as' => 'stationPay']
                ],
                [
                    '$group' => ['_id' => '$_id', 'status' => ['$first' => '$status'], 'stationCollectId' => ['$first' => '$stationCollectId'], 'stationPayId' => ['$first' => '$stationPayId'], 'amount' => ['$first' => '$amount'], 'file' => ['$first' => '$file'], 'debitDate' => ['$first' => '$debitDate'], 'created_at' => ['$first' => '$created_at'], 'deleted_at' => ['$first' => '$deleted_at'], 'payments' => ['$first' => '$payments'], 'totalPaid' => ['$sum' => ['$sum' => '$payments.amount']], 'stationCollect' => ['$first' => '$stationCollect'], 'stationPay' => ['$first' => '$stationPay']]
                ],
                [
                    '$addFields' => ['amountRemaining' => ['$subtract' => ['$amount', '$totalPaid']], 'stationCollectNickName' => ['$first' => '$stationCollect.nickName'], 'stationPayNickName' => ['$first' => '$stationPay.nickName']]
                ],
                [
                    '$project' => ['_id' => 1, 'status' => 1, 'stationCollectNickName' => 1, 'stationPayNickName' => 1, 'amount' => 1, 'amountRemaining' => 1, 'file' => 1, 'debitDate' => 1, 'created_at' => 1, 'payments' => 1]
                ],
                [
                    '$sort' => ['created_at' => -1]
                ]
            ]
        )->toArray();
    }

    public function getTableAdapterOfCollectsToPayInDateRange($stationsIds, $startDate, $endDate)
    {
        return DB::getCollection('collect')->aggregate(
            [
                [
                    '$match' => ['deleted_at' => null, 'stationPayId' => ['$in' => $stationsIds], 'debitDate' => ['$gte' => $startDate, '$lte' => $endDate]]
                ],
                [
                    '$lookup' => ['from' => 'station', 'localField' => 'stationCollectId', 'foreignField' => '_id', 'as' => 'stationCollect']
                ],
                [
                    '$lookup' => ['from' => 'station', 'localField' => 'stationPayId', 'foreignField' => '_id', 'as' => 'stationPay']
                ],
                [
                    '$group' => ['_id' => '$_id', 'status' => ['$first' => '$status'], 'stationCollectId' => ['$first' => '$stationCollectId'], 'stationPayId' => ['$first' => '$stationPayId'], 'amount' => ['$first' => '$amount'], 'file' => ['$first' => '$file'], 'debitDate' => ['$first' => '$debitDate'], 'created_at' => ['$first' => '$created_at'], 'deleted_at' => ['$first' => '$deleted_at'], 'payments' => ['$first' => '$payments'], 'totalPaid' => ['$sum' => ['$sum' => '$payments.amount']], 'stationCollect' => ['$first' => '$stationCollect'], 'stationPay' => ['$first' => '$stationPay']]
                ],
                [
                    '$addFields' => ['amountRemaining' => ['$subtract' => ['$amount', '$totalPaid']], 'stationCollectNickName' => ['$first' => '$stationCollect.nickName'], 'stationPayNickName' => ['$first' => '$stationPay.nickName']]
                ],
                [
                    '$project' => ['_id' => 1, 'status' => 1, 'stationCollectNickName' => 1, 'stationPayNickName' => 1, 'amount' => 1, 'amountRemaining' => 1, 'file' => 1, 'debitDate' => 1, 'created_at' => 1, 'payments' => 1]
                ],
                [
                    '$sort' => ['created_at' => -1]
                ]
            ]
        )->toArray();
    }

    public function getTableAdapterOfCollectsPendingProccessingInDateRange($startDate, $endDate)
    {
        return DB::getCollection('collect')->aggregate(
            [
                [
                    '$match' => ['deleted_at' => null, 'status' => 'PENDIENTE', 'debitDate' => ['$gte' => $startDate, '$lte' => $endDate]]
                ],
                [
                    '$lookup' => ['from' => 'station', 'localField' => 'stationCollectId', 'foreignField' => '_id', 'as' => 'stationCollect']
                ],
                [
                    '$lookup' => ['from' => 'station', 'localField' => 'stationPayId', 'foreignField' => '_id', 'as' => 'stationPay']
                ],
                [
                    '$group' => ['_id' => '$_id', 'status' => ['$first' => '$status'], 'stationCollectId' => ['$first' => '$stationCollectId'], 'stationPayId' => ['$first' => '$stationPayId'], 'amount' => ['$first' => '$amount'], 'file' => ['$first' => '$file'], 'debitDate' => ['$first' => '$debitDate'], 'created_at' => ['$first' => '$created_at'], 'deleted_at' => ['$first' => '$deleted_at'], 'payments' => ['$first' => '$payments'], 'totalPaid' => ['$sum' => ['$sum' => '$payments.amount']], 'stationCollect' => ['$first' => '$stationCollect'], 'stationPay' => ['$first' => '$stationPay']]
                ],
                [
                    '$addFields' => ['amountRemaining' => ['$subtract' => ['$amount', '$totalPaid']], 'stationCollectNickName' => ['$first' => '$stationCollect.nickName'], 'stationPayNickName' => ['$first' => '$stationPay.nickName']]
                ],
                [
                    '$project' => ['_id' => 1, 'status' => 1, 'stationCollectNickName' => 1, 'stationPayNickName' => 1, 'amount' => 1, 'amountRemaining' => 1, 'file' => 1, 'debitDate' => 1, 'created_at' => 1, 'payments' => 1]
                ],
                [
                    '$sort' => ['created_at' => -1]
                ]
            ]
        )->toArray();
    }

    public function getTotalPaid($id)
    {
        return DB::getCollection('collect')->aggregate(
            [
                [
                    '$match' => ['deleted_at' => null, '_id' => $id]
                ],
                [
                    '$group' => ['_id' => '$_id', 'amount' => ['$first' => '$amount'], 'totalPaid' => ['$sum' => ['$sum' => '$payments.amount']]]
                ],
                [
                    '$addFields' => ['amountRemaining' => ['$subtract' => ['$amount', '$totalPaid']]]
                ],
                [
                    '$project' => ['_id' => 1, 'amount' => 1, 'amountRemaining' => 1]
                ]
            ]
        )->toArray();
    }

    public function savePayment($id, $paymentId, $userId, $amount, $paymentDate)
    {
        return DB::collection('collect')->where('_id', $id)->whereNull('deleted_at')->update([
            '$push' => [
                'payments' => [
                    '_id' => $paymentId,
                    'userId' => $userId,
                    'amount' => $amount,
                    'file' => null,
                    'paymentDate' => $paymentDate
                ]
            ]
        ]);
    }

    public function updatePaymentFile($id, $paymentId, $file)
    {
        return DB::collection('collect')->where('_id', $id)->where('payments._id', $paymentId)->whereNull('deleted_at')->update(
            ['payments.$.file' => $file]
        );
    }

    public function deletePayment($id, $paymentId)
    {
        return DB::collection('collect')->where('_id', $id)->update([
            '$pull' => [
                'payments' => ['_id' => $paymentId]
            ]
        ]);
    }

    public function authorize($id)
    {
        return DB::collection('collect')->where('_id', $id)->whereNull('deleted_at')->update(['status' => 'AUTORIZADA']);
    }

    public function reject($id, $rejectedNote)
    {
        return DB::collection('collect')->where('_id', $id)->whereNull('deleted_at')->update(['status' => 'RECHAZADA', 'rejectedNote' => $rejectedNote]);
    }
}
