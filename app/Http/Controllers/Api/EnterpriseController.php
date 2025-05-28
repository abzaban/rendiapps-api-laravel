<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Enterprise\SaveRequest;
use App\Http\Requests\Enterprise\UpdateRequest;

use App\Models\EnterpriseModel;

use App\Responses\DefaultResponse;

class EnterpriseController extends Controller
{
    private $enterpriseModel;

    function __construct()
    {
        $this->enterpriseModel = new EnterpriseModel();
    }

    public function save(SaveRequest $request)
    {
        $saved = $this->enterpriseModel->save(
            $request->townId,
            $request->businessName,
            $request->nickName,
            $request->rfc,
            $request->email,
            $request->cellphones,
            $request->serverDomain,
            $request->category,
            $request->segment
        );
        if (!$saved)
            return response()->json(new DefaultResponse(true, 'Error al registrar la empresa'));

        return response()->json(new DefaultResponse(false, 'Empresa registrada con éxito'));
    }

    public function getAll()
    {
        $enterprises = $this->enterpriseModel->getAll();
        if (!$enterprises)
            return response()->json(new DefaultResponse(true, 'No hay empresas disponibles'));

        return response()->json(new DefaultResponse(false, 'Empresas obtenidas con éxito', $enterprises));
    }

    public function update(UpdateRequest $request)
    {
        $updated = $this->enterpriseModel->update(
            $request->enterpriseId,
            $request->townId,
            $request->businessName,
            $request->nickName,
            $request->rfc,
            $request->email,
            $request->cellphones,
            $request->serverDomain,
            $request->category,
            $request->segment
        );
        if (!$updated)
            return response()->json(new DefaultResponse(true, 'Error al actualizar la información de la empresa'));

        return response()->json(new DefaultResponse(false, 'Información de la empresa actualizada con éxito'));
    }

    public function delete($enterpriseId)
    {
        $deleted = $this->enterpriseModel->delete($enterpriseId);
        if (!$deleted)
            return response()->json(new DefaultResponse(true, 'Error al dar de baja la empresa'));

        return response()->json(new DefaultResponse(false, 'Empresa dada de baja con éxito'));
    }

    public function getTableAdapter()
    {
        $enterprises = $this->enterpriseModel->getTableAdapter();
        if (!$enterprises)
            return response()->json(new DefaultResponse(true, 'Error al obtener las empresas'));

        return response()->json(new DefaultResponse(false, 'Empresas obtenidas con éxito', $enterprises));
    }

    public function get($enterpriseId)
    {
        $enterprise = $this->enterpriseModel->get($enterpriseId);
        if (!$enterprise)
            return response()->json(new DefaultResponse(true, 'Error al obtener la empresa'));

        return response()->json(new DefaultResponse(false, 'Empresa obtenida con éxito', $enterprise));
    }
}
