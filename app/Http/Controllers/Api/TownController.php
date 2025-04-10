<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\TownModel;

use App\Responses\DefaultResponse;

class TownController extends Controller
{
    private $townModel;

    function __construct()
    {
        $this->townModel = new TownModel();
    }

    public function getAll()
    {
        $towns = $this->townModel->getAll();
        if (!$towns)
            return response()->json(new DefaultResponse(true, 'Error al obtener los municipios'));

        return response()->json(new DefaultResponse(false, 'Municipios obtenidos con éxito', $towns));
    }
}
