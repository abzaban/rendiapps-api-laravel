<?php

namespace App\Models;

use App\Repositories\CollectRepository;

use App\Formatters\CollectFormatter;
use App\Formatters\MongoDBFormatter;

class CollectModel
{
    private $collectRepository, $collectFormatter, $mongoFormatter;

    function __construct()
    {
        $this->collectRepository = new CollectRepository();
        $this->collectFormatter = new CollectFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function save($stationCollectId, $stationPayId, $userId, $amount, $debitDate)
    {
        return $this->mongoFormatter->objectIdToStringId($this->collectRepository->save(
            $this->mongoFormatter->stringIdToObjectId($stationCollectId),
            $this->mongoFormatter->stringIdToObjectId($stationPayId),
            $this->mongoFormatter->stringIdToObjectId($userId),
            $amount,
            $this->mongoFormatter->stringDateToTimestamp($debitDate),
            $this->mongoFormatter->stringDateToTimestamp(now())
        ));
    }

    public function delete($id)
    {
        return $this->collectRepository->delete($this->mongoFormatter->stringIdToObjectId($id), $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function getPaymentFile($id, $paymentId)
    {
        $collect = $this->collectFormatter->toDomain((object) $this->collectRepository->get($this->mongoFormatter->stringIdToObjectId($id)));
        foreach ($collect->getPayments() as $payment) {
            if ($payment->getId() != $paymentId)
                continue;

            return $payment->getFile();
        }

        return null;
    }

    public function updateFile($id, $file)
    {
        return $this->collectRepository->updateFile($id, $file);
    }

    public function getTableAdapterOfCollectsToCollectInDateRange($stationsIds, $startDate, $endDate)
    {
        return $this->collectFormatter->toTable($this->collectRepository->getTableAdapterOfCollectsToCollectInDateRange(
            $stationsIds,
            $this->mongoFormatter->stringDateToTimestamp($startDate),
            $this->mongoFormatter->stringDateToTimestamp($endDate),
        ));
    }

    public function getTableAdapterOfCollectsToPayInDateRange($stationsIds, $startDate, $endDate)
    {
        return $this->collectFormatter->toTable($this->collectRepository->getTableAdapterOfCollectsToPayInDateRange(
            $stationsIds,
            $this->mongoFormatter->stringDateToTimestamp($startDate),
            $this->mongoFormatter->stringDateToTimestamp($endDate),
        ));
    }

    public function getTableAdapterOfCollectsPendingProccessingInDateRange($startDate, $endDate)
    {
        return $this->collectFormatter->toTable($this->collectRepository->getTableAdapterOfCollectsPendingProccessingInDateRange(
            $this->mongoFormatter->stringDateToTimestamp($startDate),
            $this->mongoFormatter->stringDateToTimestamp($endDate),
        ));
    }

    public function getTotalPaid($id)
    {
        $dataPayment = $this->collectRepository->getTotalPaid($this->mongoFormatter->stringIdToObjectId($id));
        return sizeof($dataPayment) == 1 ? $dataPayment[0] : null;
    }

    public function savePayment($id, $userId, $amount, $paymentDate)
    {
        $paymentId = $this->mongoFormatter->newObjectId();
        $saved = $this->collectRepository->savePayment(
            $this->mongoFormatter->stringIdToObjectId($id),
            $paymentId,
            $this->mongoFormatter->stringIdToObjectId($userId),
            $amount,
            $this->mongoFormatter->stringDateToTimestamp($paymentDate)
        );

        return $saved ? $paymentId : null;
    }

    public function updatePaymentFile($id, $paymentId, $file)
    {
        return $this->collectRepository->updatePaymentFile($id, $paymentId, $file);
    }

    public function deletePayment($id, $paymentId)
    {
        return $this->collectRepository->deletePayment(
            $this->mongoFormatter->stringIdToObjectId($id),
            $this->mongoFormatter->stringIdToObjectId($paymentId)
        );
    }

    public function authorize($id)
    {
        return $this->collectRepository->authorize($this->mongoFormatter->stringIdToObjectId($id));
    }

    public function reject($id, $rejectedNote)
    {
        return $this->collectRepository->reject($this->mongoFormatter->stringIdToObjectId($id), $rejectedNote);
    }

    // public function getCobranzaRemainder($id)
    // {
    //     try {
    //         $query = $this->collectRepository->getCobranzaTotalPaid(new ObjectId($id))->toArray()[0];
    //         $amount = $query->jsonSerialize()->monto;
    //         $totalPaid = $query->jsonSerialize()->totalPagado;
    //         return $amount - $totalPaid;
    //     } catch (Exception $e) {
    //         return null;
    //     }
    // }

    // public function savePago($data)
    // {
    //     try {
    //         $data['idCobranza'] = new ObjectId($data['idCobranza']);
    //         $data['_id'] = new ObjectId();
    //         $data['idUsuario'] = new ObjectId($data['idUsuario']);
    //         $data['fechaPago'] = new Timestamp(1, strtotime($data['fechaPago']));
    //         $data['created_at'] = new Timestamp(1, now()->getTimestamp());
    //         return $this->collectRepository->savePago($data);
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    // public function getCobranza($id)
    // {
    //     try {
    //         $cobranzaRaw = $this->collectRepository->get(new ObjectId($id))->toArray()[0];
    //         $cobranzaRaw['id'] = $cobranzaRaw->_id->__toString();
    //         $cobranzaRaw['fechaAdeudo'] = date('d/m/Y', $cobranzaRaw->fechaAdeudo->getTimestamp());
    //         $cobranzaRaw['created_at'] = date('d/m/Y', $cobranzaRaw->created_at->getTimestamp());

    //         $pagosFormated = [];
    //         foreach ($cobranzaRaw['pagos'] as $pago) {
    //             $pagoFormated = new stdClass;
    //             $pagoFormated->id = $pago->_id->__toString();
    //             $pagoFormated->idUsuario = $pago->idUsuario->__toString();
    //             $pagoFormated->monto = $pago->monto;
    //             $pagoFormated->fechaPago = date('d/m/Y', $pago->fechaPago->getTimestamp());
    //             $pagoFormated->archivo = $pago->archivo;
    //             $pagosFormated[] = $pagoFormated;
    //         }
    //         $cobranzaRaw['pagos'] = $pagosFormated;

    //         unset($cobranzaRaw->_id);
    //         return $cobranzaRaw;
    //     } catch (Exception $e) {
    //         return null;
    //     }
    // }

    // public function getUrlFileOfPago($id, $pagoId)
    // {
    //     $cobranza = $this->getCobranza($id);
    //     foreach ($cobranza->pagos as $pago)
    //         if ($pago->id == $pagoId)
    //             return substr($pago->archivo, 48);
    //     return null;
    // }
}
