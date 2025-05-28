<?php

namespace App\Http\Middleware;

use Closure, ErrorException;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Models\TokenModel;

use App\Responses\DefaultResponse;

class ValidateJWT
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->ra_token;
        } catch (ErrorException $ee) {
            return response()->json(new DefaultResponse(true, 'Token no recibido'));
        }

        $tokenModel = new TokenModel();
        try {
            $userId = $tokenModel->getUserIdByToken($token);
        } catch (TokenExpiredException $tee) {
            return response()->json(new DefaultResponse(true, 'Token expirado'));
        } catch (TokenInvalidException $tie) {
            return response()->json(new DefaultResponse(true, 'Token no válido'));
        }

        $sessionToken = $tokenModel->getByUserId($userId)->getAuthToken();
        if (!$sessionToken)
            return response()->json(new DefaultResponse(true, 'Usuario sin sesión'));

        if ($sessionToken != $token)
            return response()->json(new DefaultResponse(true, 'Token no válido, el usuario ya cuenta con una sesión'));

        $request->merge(['sessionUserId' => $userId]);
        return $next($request);
    }
}
