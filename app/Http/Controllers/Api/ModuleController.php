<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\UserModel;
use App\Models\ModuleModel;

use App\Responses\DefaultResponse;

class ModuleController extends Controller
{
    private $userModel, $moduleModel;

    function __construct()
    {
        $this->userModel = new UserModel();
        $this->moduleModel = new ModuleModel();
    }

    public function getAll()
    {
        $modules = $this->moduleModel->getAll();
        if (!$modules)
            return response()->json(new DefaultResponse(true, 'Sin módulos disponibles'));

        return response()->json(new DefaultResponse(false, 'Módulos obtenidos con éxito', $modules));
    }

    public function getModulesOfUser(Request $request)
    {
        $modulesIds = $this->userModel->getModulesIds($request->sessionUserId);
        if (!$modulesIds)
            return response()->json(new DefaultResponse(true, 'El usuario no tiene módulos'));

        $modules = $this->moduleModel->getByIds($modulesIds);
        if (!$modules)
            return response()->json(new DefaultResponse(true, 'Error al obtener los módulos'));

        return response()->json(new DefaultResponse(false, 'Modulos obtenidos con éxito', $modules));
    }
}
