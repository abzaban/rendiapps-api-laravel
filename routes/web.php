<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\RecoverPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(RecoverPasswordController::class)->group(function () {
    Route::get('recoverPassword/getResetView', 'getResetView');
});
