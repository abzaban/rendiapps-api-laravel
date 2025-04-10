<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Exception;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\RecoverPassword\SendMailRequest;
use App\Http\Requests\RecoverPassword\ResetPasswordRequest;
use App\Http\Requests\RecoverPassword\ResetPasswordViewRequest;

use App\Models\TokenModel;
use App\Models\UserModel;
use App\Models\Mail\MailModel;

use App\Responses\DefaultResponse;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RecoverPasswordController extends Controller
{
    private $mailModel, $userModel, $tokenModel;

    function __construct()
    {
        $this->mailModel = new MailModel();
        $this->userModel = new UserModel();
        $this->tokenModel = new TokenModel();
    }

    public function sendMail(SendMailRequest $request)
    {
        $user = $this->userModel->getByEmail($request->email);

        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        $token = $this->tokenModel->generateJwtToken($user->getId(), $user->getEmail());
        $pwdTokenIsUpdated = $this->tokenModel->updatePwdToken($session, $user->getId(), $token->get());
        if (!$pwdTokenIsUpdated) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al actualizar el token de recuperación'));
        }

        $emailSent = $this->mailModel->send($request->email, $token->get());
        if (!$emailSent) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Correo no enviado'));
        }

        $session->commitTransaction();
        return response()->json(new DefaultResponse(false, 'Correo enviado'));
    }

    public function getResetView(ResetPasswordViewRequest $request)
    {
        try {
            $userId = $this->tokenModel->getUserIdByToken($request->pwdToken);
        } catch (Exception $e) {
            return view('Permissions.denied');
        }

        $pwdToken = $this->tokenModel->getByUserId($userId)->getPwdToken();
        if (!$pwdToken)
            return view('Permissions.denied');

        return view('view_recuperar_pwd', ['token' => $request->pwdToken]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $userId = $this->tokenModel->getUserIdByToken($request->pwdToken);

        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        $passwordUpdated = $this->userModel->updatePassword($session, $userId, $request->password);
        if (!$passwordUpdated) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al actualizar la contraseña'));
        }

        $pwdTokenUpdated = $this->tokenModel->updatePwdToken($session, $userId, null);
        if (!$pwdTokenUpdated) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al actualizar el token de recuperación'));
        }

        $session->commitTransaction();
        return response()->json(new DefaultResponse(false, 'Contraseña actualizada con éxito'));
    }
}
