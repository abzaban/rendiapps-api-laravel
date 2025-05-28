<?php

namespace App\Formatters;

use App\Domain\Account;
use App\Domain\Balance;
use App\Domain\Wallet;

use App\Adapters\WalletTableAdapter;

class WalletFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data)) {
            $accounts = [];
            foreach ($data->accounts as $account) {
                $account = (object)$account;

                $balances = [];
                foreach ($account->balances as $balance) {
                    $balance = (object) $balance;
                    $balances[] = new Balance(
                        $this->mongoFormatter->objectIdToStringId($balance->_id),
                        $balance->asset,
                        $balance->created_at
                    );
                }

                $accounts[] = new Account(
                    $this->mongoFormatter->objectIdToStringId($account->_id),
                    $account->bankName,
                    $account->accountNumber,
                    $balances
                );
            }
            return new Wallet($this->mongoFormatter->objectIdToStringId($data->_id), $accounts);
        }

        $dataFormatted = [];
        foreach ($data as $wallet) {
            $wallet = (object) $wallet;

            $accounts = [];
            foreach ($wallet->accounts as $account) {
                $account = (object)$account;

                $balances = [];
                foreach ($account->balances as $balance) {
                    $balance = (object) $balance;
                    $balances[] = new Balance(
                        $this->mongoFormatter->objectIdToStringId($balance->_id),
                        $balance->asset,
                        $balance->created_at
                    );
                }

                $accounts[] = new Account(
                    $this->mongoFormatter->objectIdToStringId($account->_id),
                    $account->bankName,
                    $account->accountNumber,
                    $balances
                );
            }
            $dataFormatted[] = new Wallet($this->mongoFormatter->objectIdToStringId($wallet->_id), $accounts);
        }
        return $dataFormatted;
    }

    public function toTable($data)
    {
        if (!is_array($data)) {
            $ownerNickName = property_exists($data, 'stationNickName') ? $data->stationNickName : $data->enterpriseNickName;

            $accounts = [];
            foreach ($data->accounts as $account) {
                $account = (object)$account;

                $balances = [];
                foreach ($account->balances as $balance) {
                    $balance = (object) $balance;
                    $balances[] = new Balance(
                        $this->mongoFormatter->objectIdToStringId($balance->_id),
                        $balance->asset,
                        $balance->created_at
                    );
                }

                $accounts[] = new Account(
                    $this->mongoFormatter->objectIdToStringId($account->_id),
                    $account->bankName,
                    $account->accountNumber,
                    $balances
                );
            }
            return new WalletTableAdapter($this->mongoFormatter->objectIdToStringId($data->_id), $ownerNickName, $accounts);
        }

        $dataFormatted = [];
        foreach ($data as $wallet) {
            $wallet = (object) $wallet;
            $ownerNickName = property_exists($wallet, 'stationNickName') ? $wallet->stationNickName : $wallet->enterpriseNickName;

            $accounts = [];
            foreach ($wallet->accounts as $account) {
                $account = (object)$account;

                $balances = [];
                foreach ($account->balances as $balance) {
                    $balance = (object) $balance;
                    $balances[] = new Balance(
                        $this->mongoFormatter->objectIdToStringId($balance->_id),
                        $balance->asset,
                        $balance->created_at
                    );
                }

                $accounts[] = new Account(
                    $this->mongoFormatter->objectIdToStringId($account->_id),
                    $account->bankName,
                    $account->accountNumber,
                    $balances
                );
            }
            $dataFormatted[] = new WalletTableAdapter($this->mongoFormatter->objectIdToStringId($wallet->_id), $ownerNickName, $accounts);
        }
        return $dataFormatted;
    }
}
