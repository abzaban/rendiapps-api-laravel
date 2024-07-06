<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\ValidateJWT;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecoverPasswordController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EnterpriseController;
use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\CobranzaController;
use App\Http\Controllers\Api\CollectController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\TownController;

// auth module
Route::controller(AuthController::class)->group(function () {
    Route::post('auth/login', 'login');
    Route::post('auth/logout', 'logout')->middleware(ValidateJWT::class);
    Route::post('auth/renewToken', 'renewToken');
});

// recover password module
Route::controller(RecoverPasswordController::class)->group(function () {
    Route::post('recoverPassword/sendMail', 'sendMail');
    Route::post('recoverPassword/reset', 'reset');
});

Route::middleware(ValidateJWT::class)->group(function () {
    // towns
    Route::controller(TownController::class)->group(function () {
        Route::get('towns', 'getAll');
    });

    // modules
    Route::controller(ModuleController::class)->group(function () {
        Route::get('modules', 'getAll');
        Route::get('modules/getModulesOfUser', 'getModulesOfUser');
    });

    // users
    Route::controller(UserController::class)->group(function () {
        Route::post('users', 'save');
        Route::get('users', 'getAll');
        Route::put('users/{userId}', 'update');
        Route::delete('users/{userId}', 'delete');
        Route::get('users/{userId}', 'get');
        Route::put('users/{userId}/updatePassword', 'updatePassword');
    });

    // enterprises
    Route::controller(EnterpriseController::class)->group(function () {
        Route::post('enterprises', 'save');
        Route::get('enterprises', 'getAll');
        Route::put('enterprises/{enterpriseId}', 'update');
        Route::delete('enterprises/{enterpriseId}', 'delete');
        Route::get('enterprises/getTableAdapter', 'getTableAdapter');
        Route::get('enterprises/{enterpriseId}', 'get');
    });

    // stations
    Route::controller(StationController::class)->group(function () {
        Route::post('stations', 'save');
        Route::get('stations', 'getAll');
        Route::put('stations/{stationId}', 'update');
        Route::delete('stations/{stationId}', 'delete');
        Route::get('stations/getTableAdapter', 'getTableAdapter');
        Route::get('stations/getStationsOfUser', 'getStationsOfUser');
        Route::get('stations/{stationId}', 'get');
    });

    // Módulo de cobranzas
    Route::controller(CobranzaController::class)->group(function () {
        Route::post('cobranzas', 'saveCobranza');
        Route::get('cobranzas', 'getCobranzas');
        Route::delete('cobranzas/{id}', 'deleteCobranza');
        Route::post('cobranzas/pago', 'savePago');
        Route::put('cobranzas/pago/{idPago}', 'removePago');
        Route::get('cobranzas/pago/authorize/{id}', 'authorizeCobranza');
        Route::post('cobranzas/pago/reject/{id}', 'rejectCobranza');
    });

    // collects
    Route::controller(CollectController::class)->group(function () {
        Route::post('collects', 'save');
        Route::delete('collects/{collectId}', 'delete');
        Route::get('collects/getTableAdapterOfCollectsToCollectInDateRange', 'getTableAdapterOfCollectsToCollectInDateRange');
        Route::get('collects/getTableAdapterOfCollectsToPayInDateRange', 'getTableAdapterOfCollectsToPayInDateRange');
        Route::get('collects/getTableAdapterOfCollectsPendingProccessingInDateRange', 'getTableAdapterOfCollectsPendingProccessingInDateRange');
        Route::post('collects/{collectId}/payments', 'savePayment');
        Route::delete('collects/{collectId}/payments/{paymentId}', 'deletePayment');
        Route::get('collects/{collectId}/authorize', 'authorizeCollect');
        Route::post('collects/{collectId}/reject', 'rejectCollect');
    });

    // wallets
    Route::controller(WalletController::class)->group(function () {
        Route::put('carteras/{walletId}/cuentas/{accountId}', 'updateAccount');
        Route::delete('carteras/{walletId}/cuentas/{accountId}', 'removeAccount');
        Route::post('carteras/{walletId}/cuentas/{accountId}/saldos/', 'addBalance');
        Route::put('carteras/{walletId}/cuentas/{accountId}/saldos/{balanceId}', 'updateBalance');
        Route::delete('carteras/{walletId}/cuentas/{accountId}/saldos/{balanceId}', 'removeBalance');
    });

    // wallets
    Route::controller(WalletController::class)->group(function () {
        Route::get('wallets/getTableAdapter', 'getTableAdapter');
        Route::get('wallets/{ownerId}', 'get');
        Route::post('wallets/{ownerId}/accounts', 'addAccount');
        Route::put('wallets/{ownerId}/accounts/{accountId}', 'updateAccount');
        Route::delete('wallets/{ownerId}/accounts/{accountId}', 'deleteAccount');
    });

    // stations
    Route::controller(DepartmentController::class)->group(function () {
        Route::post('departments', 'save');
        Route::get('departments', 'getAll');
        Route::put('departments/{departmentId}', 'update');
        Route::delete('departments/{departmentId}', 'delete');
        Route::get('departments/getTableAdapter', 'getTableAdapter');
        Route::get('departments/{departmentId}', 'get');
    });
});
