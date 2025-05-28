<?php

namespace App\Formatters;

use App\Domain\Collect;
use App\Domain\Payment;

use App\Adapters\CollectTableAdapter;

class CollectFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data)) {
            $payments = [];
            foreach ($data->payments as $payment) {
                $payment = (object) $payment;
                $payments[] = new Payment(
                    $this->mongoFormatter->objectIdToStringId($payment->_id),
                    $payment->userId,
                    $payment->amount,
                    $payment->file,
                    $payment->paymentDate
                );
            }

            return new Collect(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->stationCollectId,
                $data->stationPayId,
                $data->status,
                $data->amount,
                $data->file,
                $this->mongoFormatter->timestampToStringDate($data->debitDate),
                $payments
            );
        }

        $dataFormatted = [];
        foreach ($data as $collect) {
            $collect = (object) $collect;

            $payments = [];
            foreach ($collect->payments as $payment) {
                $payment = (object) $payment;
                $payments[] = new Payment(
                    $this->mongoFormatter->objectIdToStringId($payment->_id),
                    $payment->userId,
                    $payment->amount,
                    $payment->file,
                    $payment->paymentDate
                );
            }

            $dataFormatted[] = new Collect(
                $this->mongoFormatter->objectIdToStringId($collect->_id),
                $collect->stationCollectId,
                $collect->stationPayId,
                $collect->status,
                $collect->amount,
                $collect->file,
                $this->mongoFormatter->timestampToStringDate($collect->debitDate),
                $payments
            );
        }

        return $dataFormatted;
    }

    public function toTable($data)
    {
        if (!is_array($data)) {
            $payments = [];
            foreach ($data->payments as $payment) {
                $payment = (object) $payment;
                $payments[] = new Payment(
                    $this->mongoFormatter->objectIdToStringId($payment->_id),
                    $payment->userId,
                    $payment->amount,
                    $payment->file,
                    $payment->paymentDate
                );
            }

            return new CollectTableAdapter(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->stationCollectNickName,
                $data->stationPayNickName,
                $data->status,
                $data->amount,
                $data->amountRemaining,
                $data->file,
                $this->mongoFormatter->timestampToStringDate($data->debitDate),
                $this->mongoFormatter->timestampToStringDate($data->created_at),
                $payments
            );
        }

        $dataFormatted = [];
        foreach ($data as $collect) {
            $collect = (object) $collect;

            $payments = [];
            foreach ($collect->payments as $payment) {
                $payment = (object) $payment;
                $payments[] = new Payment(
                    $this->mongoFormatter->objectIdToStringId($payment->_id),
                    $this->mongoFormatter->objectIdToStringId($payment->userId),
                    $payment->amount,
                    $payment->file,
                    $this->mongoFormatter->timestampToStringDate($payment->paymentDate)
                );
            }

            $dataFormatted[] = new CollectTableAdapter(
                $this->mongoFormatter->objectIdToStringId($collect->_id),
                $collect->stationCollectNickName,
                $collect->stationPayNickName,
                $collect->status,
                $collect->amount,
                $collect->amountRemaining,
                $collect->file,
                $this->mongoFormatter->timestampToStringDate($collect->debitDate),
                $this->mongoFormatter->timestampToStringDate($collect->created_at),
                $payments
            );
        }

        return $dataFormatted;
    }
}
