<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\financesController\AddBalanceRequest;
use App\Http\Requests\financesController\UpdateBalanceRequest;
use App\Http\Requests\Wallet\AddAccountRequest;
use App\Http\Requests\Wallet\UpdateAccountRequest;

use App\Models\WalletModel;
use App\Models\EnterpriseModel;
use App\Models\StationModel;

use App\Responses\DefaultResponse;

class WalletController extends Controller
{
    private $walletModel, $stationModel, $enterpriseModel;

    public function __construct()
    {
        $this->walletModel = new WalletModel();
        $this->stationModel = new StationModel();
        $this->enterpriseModel = new EnterpriseModel();
    }

    public function get($ownerId)
    {
        $wallet = $this->walletModel->get($ownerId);
        if (!$wallet)
            return response()->json(new DefaultResponse(true, 'Error al obtener la cartera'));

        return response()->json(new DefaultResponse(false, 'Cartera obtenida con éxito', $wallet));
    }

    public function getTableAdapter()
    {
        $wallets = $this->walletModel->getTableAdapterOfWallets();
        if (!$wallets)
            return response()->json(new DefaultResponse(true, 'No hay carteras registradas'));

        return response()->json(new DefaultResponse(false, 'Carteras obtenidas con éxito', $wallets));
    }

    public function addAccount(AddAccountRequest $request)
    {
        $wallet = $this->walletModel->get($request->ownerId);
        if ($wallet) { // se tiene solamente que añadir un elemento al arreglo de cuentas de la cartera
            $added = $this->walletModel->addAccount($request->ownerId, $request->bankName, $request->accountNumber);
            if (!$added)
                return response()->json(new DefaultResponse(true, 'Error al registrar la cuenta'));
        } else { // se tiene que crear la cartera
            // primero se verifica que sea una estacion o empresa valida
            $owner = $this->stationModel->get($request->ownerId);
            if (!$owner) {
                $owner = $this->enterpriseModel->get($request->ownerId);
                if (!$owner)
                    return response()->json(new DefaultResponse(true, 'Datos del propietario no válidos'));
            }

            $created = $this->walletModel->create($request->ownerId, $request->bankName, $request->accountNumber);
            if (!$created)
                return response()->json(new DefaultResponse(true, 'Error al registrar la cartera'));
        }

        return response()->json(new DefaultResponse(false, 'Cuenta registrada con éxito'));
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $updated = $this->walletModel->updateAccount($request->ownerId, $request->accountId, $request->bankName, $request->accountNumber);
        if (!$updated)
            return response()->json(new DefaultResponse(true, 'No se pudo actualizar la cuenta'));

        return response()->json(new DefaultResponse(false, 'Cuenta actualizada con éxito'));
    }

    public function deleteAccount($ownerId, $accountId)
    {
        $deleted = $this->walletModel->deleteAccount($ownerId, $accountId);
        if (!$deleted)
            return response()->json(new DefaultResponse(true, 'No se pudo eliminar la cuenta'));

        return response()->json(new DefaultResponse(false, 'Cuenta eliminada con éxito'));
    }

    // public function addBalance(AddBalanceRequest $request)
    // {
    //     $balanceAdded = $this->walletModel->addBalance($request->walletId, $request->accountId, $request->capital);
    //     if (!$balanceAdded)
    //         return json_encode(new DefaultResponse(true, 'No se pudo registrar el nuevo saldo'));

    //     return json_encode(new DefaultResponse(false, 'Saldo registrado con éxito'));
    // }

    // public function updateBalance(UpdateBalanceRequest $request)
    // {
    //     $balanceUpdated = $this->walletModel->updateBalance($request->walletId, $request->accountId, $request->balanceId, $request->capital);
    //     if (!$balanceUpdated)
    //         return json_encode(new DefaultResponse(true, 'No se pudo actualizar el saldo'));

    //     return json_encode(new DefaultResponse(false, 'Saldo actualizado con éxito'));
    // }

    // public function removeBalance($walletId, $accountId, $balanceId)
    // {
    //     $balanceRemoved = $this->walletModel->removeBalance($walletId, $accountId, $balanceId);
    //     if (!$balanceRemoved)
    //         return json_encode(new DefaultResponse(true, 'No se pudo eliminar el saldo'));

    //     return json_encode(new DefaultResponse(false, 'Saldo eliminado con éxito'));
    // }
}
