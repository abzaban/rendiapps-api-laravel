<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\User\SaveRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UpdatePasswordRequest;

use App\Models\UserModel;
use App\Models\TokenModel;
use App\Models\AuthModel;

use App\Responses\DefaultResponse;

class UserController extends Controller
{
    private $userModel, $tokenModel, $authModel;

    function __construct()
    {
        $this->userModel = new UserModel();
        $this->tokenModel = new TokenModel();
        $this->authModel = new AuthModel();
    }

    public function save(SaveRequest $request)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        $userInserted = $this->userModel->save(
            $session,
            $request->firstName,
            $request->lastName,
            $request->address,
            $request->email,
            $request->username,
            $this->authModel->encryptPassword($request->password),
            $request->permissions
        );
        if (!$userInserted) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al registrar el usuario'));
        }

        $user = $this->userModel->getByEmail($request->email);

        $tokenInserted = $this->tokenModel->registerSessionUser($user->getId());
        if (!$tokenInserted) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al registrar la sesión'));
        }

        $session->commitTransaction();
        return response()->json(new DefaultResponse(false, 'Usuario registrado con éxito', $user));
    }

    public function getAll()
    {
        $users = $this->userModel->getAll();
        if (!$users)
            return response()->json(new DefaultResponse(true, 'Error al obtener los usuarios'));

        return response()->json(new DefaultResponse(false, 'Usuarios obtenidos con éxito', $users));
    }

    public function update(UpdateRequest $request)
    {
        $updated = $this->userModel->update($request->userId, $request->firstName, $request->lastName, $request->address, $request->permissions);
        if (!$updated)
            return response()->json(new DefaultResponse(true, 'Error al actualizar el usuario'));

        return response()->json(new DefaultResponse(false, 'Usuario actualizado con éxito'));
    }

    public function delete($userId)
    {
        $session = DB::getMongoClient()->startSession();
        $session->startTransaction();

        $userDeleted = $this->userModel->delete($session, $userId);
        if (!$userDeleted) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al dar de baja el usuario'));
        }

        $sessionDeleted = $this->tokenModel->deleteSessionUser($session, $userId);
        if (!$sessionDeleted) {
            $session->abortTransaction();
            return response()->json(new DefaultResponse(true, 'Error al dar de baja la sesión'));
        }

        $session->commitTransaction();
        return response()->json(new DefaultResponse(false, 'Usuario dado de baja con éxito'));
    }

    public function get($userId)
    {
        $user = $this->userModel->get($userId);
        if (!$user)
            return response()->json(new DefaultResponse(true, 'Error al obtener el usuario'));

        return response()->json(new DefaultResponse(false, 'Usuario obtenido con éxito', $user));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $updated = $this->userModel->updatePassword(null, $request->userId, $this->authModel->encryptPassword($request->password));
        if (!$updated)
            return response()->json(new DefaultResponse(true, 'Error al actualizar la contraseña'));

        return response()->json(new DefaultResponse(false, 'Contraseña actualizada con éxito'));
    }

    public function getStations(Request $request)
    {
        $stationsIds = $this->userModel->getStations($request->sessionUserId);
        if (!$stationsIds)
            return response()->json(new DefaultResponse(true, 'Error al obtener las estaciones de la base de datos'));

        return response()->json(new DefaultResponse(false, 'Estaciones del usuario obtenidas', $stationsIds));
    }
}
