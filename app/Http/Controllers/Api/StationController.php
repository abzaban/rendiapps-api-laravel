<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Station\SaveRequest;
use App\Http\Requests\Station\UpdateRequest;

use App\Models\StationModel;
use App\Models\UserModel;

use App\Responses\DefaultResponse;
use Illuminate\Http\Request;

class StationController extends Controller
{
    private $stationModel, $userModel;

    function __construct()
    {
        $this->stationModel = new StationModel();
        $this->userModel = new UserModel();
    }

    public function save(SaveRequest $request)
    {
        $saved = $this->stationModel->save(
            $request->townId,
            $request->businessName,
            $request->nickName,
            $request->rfc,
            $request->email,
            $request->cellphones,
            $request->serverDomain,
            $request->category,
            $request->segment,
            $request->stationNumber,
            $request->brand,
            $request->legalPermission
        );
        if (!$saved)
            return response()->json(new DefaultResponse(true, 'Error al registrar la estación'));

        return response()->json(new DefaultResponse(false, 'Estación registrada con éxito'));
    }

    public function getAll()
    {
        $stations = $this->stationModel->getAll();
        if (!$stations)
            return response()->json(new DefaultResponse(true, 'No hay empresas disponibles'));

        return response()->json(new DefaultResponse(false, 'Estaciones obtenidas con éxito', $stations));
    }

    public function update(UpdateRequest $request)
    {
        $updated = $this->stationModel->update(
            $request->stationId,
            $request->townId,
            $request->businessName,
            $request->nickName,
            $request->rfc,
            $request->email,
            $request->cellphones,
            $request->serverDomain,
            $request->category,
            $request->segment,
            $request->stationNumber,
            $request->brand,
            $request->legalPermission
        );
        if (!$updated)
            return response()->json(new DefaultResponse(true, 'Error al actualizar la información de la estación'));

        return response()->json(new DefaultResponse(false, 'Información de la estación actualizada con éxito'));
    }

    public function delete($stationId)
    {
        $deleted = $this->stationModel->delete($stationId);
        if (!$deleted)
            return response()->json(new DefaultResponse(true, 'Error al dar de baja la estación'));

        return response()->json(new DefaultResponse(false, 'Estación dada de baja con éxito'));
    }

    public function getTableAdapter()
    {
        $stations = $this->stationModel->getTableAdapter();
        if (!$stations)
            return response()->json(new DefaultResponse(true, 'Error al obtener las estaciones'));

        return response()->json(new DefaultResponse(false, 'Estaciones obtenidas con éxito', $stations));
    }

    public function get($stationId)
    {
        $station = $this->stationModel->get($stationId);
        if (!$station)
            return response()->json(new DefaultResponse(true, 'Error al obtener la estación'));

        return response()->json(new DefaultResponse(false, 'Estación obtenida con éxito', $station));
    }

    public function getStationsOfUser(Request $request)
    {
        $stationsIds = $this->userModel->getStations($request->sessionUserId);
        if (!$stationsIds)
            return response()->json(new DefaultResponse(true, 'El usuario no tiene estaciones'));

        $stations = $this->stationModel->getByIds($stationsIds);
        if (!$stations)
            return response()->json(new DefaultResponse(true, 'Error al obtener las estaciones'));

        return response()->json(new DefaultResponse(false, 'Estaciones obtenidas con éxito', $stations));
    }
}
