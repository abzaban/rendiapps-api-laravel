<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\TokenRequest;

use App\Models\AuthModel;
use App\Models\TokenModel;
use App\Models\UserModel;

use App\Responses\AuthResponse;
use App\Responses\DefaultResponse;

class AuthController extends Controller
{
    private $authModel, $tokenModel, $userModel;

    function __construct()
    {
        $this->authModel = new AuthModel();
        $this->tokenModel = new TokenModel();
        $this->userModel = new UserModel();
    }

    public function login(LoginRequest $request)
    {
        if ($this->authModel->loginWithEmail($request->authValue))
            $user = $this->userModel->getByEmail($request->authValue);
        else
            $user = $this->userModel->getByUsername($request->authValue);

        if (!$user)
            return response()->json(new DefaultResponse(true, 'Crendenciales erróneas'));

        $validCreds = $this->authModel->validatePassword($request->password, $user->getPassword());
        if (!$user || !$validCreds)
            return response()->json(new DefaultResponse(true, 'Crendenciales erróneas'));

        $token = $this->tokenModel->generateJwtToken($user->getId(), $user->getEmail());
        $sessionUpdated = $this->tokenModel->updateAuthToken($user->getId(), $token->get());
        if (!$sessionUpdated)
            return response()->json(new DefaultResponse(true, 'No se logró registrar la sesión'));

        return response()->json(new AuthResponse(false, 'Sesión iniciada con éxito', $user, $token->get()));
    }

    public function logout(TokenRequest $request)
    {
        $removed = $this->tokenModel->updateAuthToken($request->userId, null);
        if (!$removed)
            return response()->json(new DefaultResponse(true, 'Error al cerrar la sesión'));

        return response()->json(new DefaultResponse(false, 'Sesión cerrada con éxito'));
    }

    public function renewToken(TokenRequest $request)
    {
        try {
            $userId = $this->tokenModel->getUserIdByToken($request['ra_token']);
        } catch (TokenInvalidException $e) {
            return response()->json(new DefaultResponse(true, 'Token no válido'));
        } catch (TokenExpiredException $e) {
            return response()->json(new DefaultResponse(true, 'Token expirado'));
        }

        $sessionToken = $this->tokenModel->getByUserId($userId)->getAuthToken();
        if (!$sessionToken)
            return response()->json(new DefaultResponse(true, 'Usuario sin sesión'));

        if ($request['ra_token'] != $sessionToken)
            return response()->json(new DefaultResponse(true, 'Token no válido, el usuario ya cuenta con una sesión'));

        $user = $this->userModel->get($userId);
        $newToken = $this->tokenModel->generateJwtToken($user->getId(), $user->getEmail());
        $authTokenUpdated = $this->tokenModel->updateAuthToken($user->getId(), $newToken->get());
        if (!$authTokenUpdated)
            return response()->json(new DefaultResponse(true, 'No fue posible renovar el token'));

        return response()->json(new AuthResponse(false, 'Token renovado con éxito', $user, $newToken->get()));
    }
}
