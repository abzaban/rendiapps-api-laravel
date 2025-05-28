<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\Collect\SaveRequest;
use App\Http\Requests\Collect\GetTableAdapterInDateRangeRequest;
use App\Http\Requests\Collect\CollectIdRequest;
use App\Http\Requests\Collect\PaymentIdRequest;
use App\Http\Requests\Collect\SavePaymentRequest;
use App\Http\Requests\Collect\RejectCollectRequest;

use App\Models\CollectModel;
use App\Models\UserModel;
use App\Models\GCSModel;
use App\Models\FileModel;

use App\Responses\DefaultResponse;

class CollectController extends Controller
{
    private $collectModel, $userModel, $fileModel;

    public function __construct()
    {
        $this->collectModel = new CollectModel();
        $this->userModel = new UserModel();
        $this->fileModel = new FileModel();
    }

    public function save(SaveRequest $request)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        $savedId = $this->collectModel->save(
            $request->stationCollectId,
            $request->stationPayId,
            $request->sessionUserId,
            $request->amount,
            $request->debitDate
        );
        if (!$savedId) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al registrar la cobranza'));
        }

        $fileExploded = explode(',', $request->file);
        $fileName = $savedId . '.' . $this->fileModel->getFileNameExtension($fileExploded[0]);
        $fileContent = base64_decode($fileExploded[1]);

        $pathFile = 'rendiapps/modulos/Cobranzas entre estaciones/' . date_format(now(), 'Y') . '/' . date_format(now(), 'm') . '/cobranzas';

        $urlFile = GCSModel::upload($pathFile, $fileName, $fileContent);
        if (!$urlFile) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al momento de subir a google cloud storage'));
        }

        $updated = $this->collectModel->updateFile($savedId, $urlFile);
        if (!$updated) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al actualizar la url del archivo'));
        }

        $session->commitTransaction();
        return response()->json(new DefaultResponse(false, 'Cobranza registrada con éxito'));
    }

    public function delete(CollectIdRequest $request)
    {
        $deleted = $this->collectModel->delete($request->collectId);
        if (!$deleted)
            return response()->json(new DefaultResponse(true, 'Error al encontrar la cobranza'));

        return response()->json(new DefaultResponse(false, 'Cobranza dada de baja'));
    }

    public function getTableAdapterOfCollectsToCollectInDateRange(GetTableAdapterInDateRangeRequest $request)
    {
        $stationsIds = $this->userModel->getStations($request->sessionUserId);
        if (!$stationsIds)
            return response()->json(new DefaultResponse(true, 'El usuario no cuenta con estaciones asignadas'));

        $collects = $this->collectModel->getTableAdapterOfCollectsToCollectInDateRange($stationsIds, $request->startDate, $request->endDate);
        if (!$collects)
            return response()->json(new DefaultResponse(true, 'No hay cobranzas disponibles para ese rango de fechas'));

        return response()->json(new DefaultResponse(false, 'Cobranzas obtenidas con exito', $collects));
    }

    public function getTableAdapterOfCollectsToPayInDateRange(GetTableAdapterInDateRangeRequest $request)
    {
        $stationsIds = $this->userModel->getStations($request->sessionUserId);
        if (!$stationsIds)
            return response()->json(new DefaultResponse(true, 'El usuario no cuenta con estaciones asignadas'));

        $collects = $this->collectModel->getTableAdapterOfCollectsToPayInDateRange($stationsIds, $request->startDate, $request->endDate);
        if (!$collects)
            return response()->json(new DefaultResponse(true, 'No hay cobranzas disponibles para ese rango de fechas'));

        return response()->json(new DefaultResponse(false, 'Cobranzas obtenidas con exito', $collects));
    }

    public function getTableAdapterOfCollectsPendingProccessingInDateRange(GetTableAdapterInDateRangeRequest $request)
    {
        $collects = $this->collectModel->getTableAdapterOfCollectsPendingProccessingInDateRange($request->startDate, $request->endDate);
        if (!$collects)
            return response()->json(new DefaultResponse(true, 'No hay cobranzas disponibles para ese rango de fechas'));

        return response()->json(new DefaultResponse(false, 'Cobranzas obtenidas con exito', $collects));
    }

    public function savePayment(SavePaymentRequest $request)
    {
        $dataPayment = $this->collectModel->getTotalPaid($request->collectId);
        if ($dataPayment->amountRemaining == 0) // estan tratando de pagar una cobranza sin deuda
            return response()->json(new DefaultResponse(true, 'Cobranza sin remanente para pagar'));

        else if ($dataPayment->amountRemaining - $request->amount < 0) // estan tratando de pagar con un monto superior a la deuda de la cobranza
            return response()->json(new DefaultResponse(true, 'Monto recibido superior a la deuda de la cobranza'));

        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        $savedPaymentId = $this->collectModel->savePayment(
            $request->collectId,
            $request->sessionUserId,
            $request->amount,
            $request->paymentDate
        );
        if (!$savedPaymentId) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al registrar el pago'));
        }

        $fileExploded = explode(',', $request->file);
        $fileName = $savedPaymentId . '.' . $this->fileModel->getFileNameExtension($fileExploded[0]);
        $fileContent = base64_decode($fileExploded[1]);

        $pathFile = 'rendiapps/modulos/Cobranzas entre estaciones/' . date_format(now(), 'Y') . '/' . date_format(now(), 'm') . '/pagos';

        $urlFile = GCSModel::upload($pathFile, $fileName, $fileContent);
        if (!$urlFile) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al momento de subir a google cloud storage'));
        }

        $updated = $this->collectModel->updatePaymentFile($request->collectId, $savedPaymentId, $urlFile);
        if (!$updated) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al actualizar la url del archivo'));
        }

        $session->commitTransaction();
        return response()->json(new DefaultResponse(false, 'Pago registrado con éxito'));
    }

    public function deletePayment(PaymentIdRequest $request)
    {
        $removed = $this->collectModel->deletePayment($request->collectId, $request->paymentId);
        if (!$removed)
            return response()->json(new DefaultResponse(true, 'No se encontró el pago'));

        $urlPaymentFile = $this->collectModel->getPaymentFile($request->collectId, $request->paymentId);
        if ($urlPaymentFile) {
            $fileDeleted = GCSModel::delete($urlPaymentFile);
            if (!$fileDeleted)
                return response()->json(new DefaultResponse(true, 'No se logró eliminar el archivo en el servicio de la nube'));
        }

        return response()->json(new DefaultResponse(false, 'Pago eliminado con éxito'));
    }

    public function authorizeCollect(CollectIdRequest $request)
    {
        $authorized = $this->collectModel->authorize($request->collectId);
        if (!$authorized)
            return response()->json(new DefaultResponse(true, 'La cobranza no pudo ser autorizada'));

        return response()->json(new DefaultResponse(false, 'Cobranza autorizada con éxito'));
    }

    public function rejectCollect(RejectCollectRequest $request, $collectId)
    {
        $rejected = $this->collectModel->reject($collectId, $request->rejectedNote);
        if (!$rejected)
            return response()->json(new DefaultResponse(true, 'La cobranza no pudo ser rechazada'));

        return response()->json(new DefaultResponse(false, 'Cobranza rechazada con éxito'));
    }
}
