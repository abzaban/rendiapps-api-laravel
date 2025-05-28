<?php

namespace App\Models;

use App\Repositories\WalletRepository;

use App\Formatters\WalletFormatter;
use App\Formatters\MongoDBFormatter;

class WalletModel
{
    private $walletRepository, $walletFormatter, $mongoFormatter;

    public function __construct()
    {
        $this->walletRepository = new WalletRepository();
        $this->walletFormatter = new WalletFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function create($id, $bankName, $accountNumber)
    {
        $id = $this->mongoFormatter->stringIdToObjectId($id);
        $account = $this->mongoFormatter->arrayToBsonDocument([
            '_id' => $this->mongoFormatter->newObjectId(),
            'bankName' => $bankName,
            'accountNumber' => $accountNumber,
            'balances' => []
        ]);
        return $this->walletRepository->create($id, $account);
    }

    public function get($id)
    {
        $wallet = $this->walletRepository->get($id);
        return $wallet ? $this->walletFormatter->toDomain((object) $wallet) : null;
    }

    public function getTableAdapterOfWallets()
    {
        return $this->walletFormatter->toTable($this->walletRepository->getTableAdapterOfWallets());
    }

    public function addAccount($id, $bankName, $accountNumber)
    {
        return $this->walletRepository->addAccount(
            $this->mongoFormatter->stringIdToObjectId($id),
            $this->mongoFormatter->newObjectId(),
            $bankName,
            $accountNumber
        );
    }

    public function updateAccount($id, $accountId, $bankName, $accountNumber)
    {
        return $this->walletRepository->updateAccount(
            $this->mongoFormatter->stringIdToObjectId($id),
            $this->mongoFormatter->stringIdToObjectId($accountId),
            $bankName,
            $accountNumber
        );
    }

    public function deleteAccount($id, $accountId)
    {
        return $this->walletRepository->deleteAccount(
            $this->mongoFormatter->stringIdToObjectId($id),
            $this->mongoFormatter->stringIdToObjectId($accountId)
        );
    }

    // public function addBalance($walletId, $accountId, $asset)
    // {
    //     try {
    //         return $this->walletRepository->addBalance($walletId, $accountId, new ObjectId(), $asset, new Timestamp(1, now()->getTimestamp()));
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    // public function updateBalance($walletId, $accountId, $balanceId, $asset)
    // {
    //     try {
    //         return $this->walletRepository->updateBalance(new ObjectId($walletId), new ObjectId($accountId), new ObjectId($balanceId), $asset);
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    // public function removeBalance($walletId, $accountId, $balanceId)
    // {
    //     try {
    //         return $this->walletRepository->deleteBalance(new ObjectId($walletId), new ObjectId($accountId), new ObjectId($balanceId));
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }
}
