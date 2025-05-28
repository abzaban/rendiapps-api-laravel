<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use MongoDB\Driver\Exception\InvalidArgumentException;

use App\Http\Requests\Department\SaveRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Http\Requests\Department\IdRequest;

use App\Models\DepartmentModel;
use App\Models\StationModel;
use App\Models\EnterpriseModel;

use App\Responses\DefaultResponse;

class DepartmentController extends Controller
{
    private $departmentModel, $stationModel, $enterpriseModel;

    function __construct()
    {
        $this->departmentModel = new DepartmentModel();
        $this->stationModel = new StationModel();
        $this->enterpriseModel = new EnterpriseModel();
    }

    public function save(SaveRequest $request)
    {
        try {
            $owner = $this->stationModel->get($request->ownerId);
            if (!$owner)
                $owner = $this->enterpriseModel->get($request->ownerId);

            if (!$owner)
                return response()->json(new DefaultResponse(true, 'Propietario no encontrado'));
        } catch (InvalidArgumentException $e) {
            return response()->json(new DefaultResponse(true, 'Identificador de la Propietario no válido'));
        }

        $saved = $this->departmentModel->save($request->name, $request->ownerId);
        if (!$saved)
            return response()->json(new DefaultResponse(true, 'Error al registrar el departamento'));

        return response()->json(new DefaultResponse(false, 'Departamento registrado con éxito'));
    }

    public function getAll()
    {
        $departments = $this->departmentModel->getAll();
        if (!$departments)
            return response()->json(new DefaultResponse(true, 'No hay departamentos disponibles'));

        return response()->json(new DefaultResponse(false, 'Departamentos obtenidos con éxito', $departments));
    }

    public function update(UpdateRequest $request)
    {
        try {
            $owner = $this->stationModel->get($request->ownerId);
            if (!$owner)
                $owner = $this->enterpriseModel->get($request->ownerId);

            if (!$owner)
                return response()->json(new DefaultResponse(true, 'Propietario no encontrado'));
        } catch (InvalidArgumentException $e) {
            return response()->json(new DefaultResponse(true, 'Identificador de la Propietario no válido'));
        }

        $updated = $this->departmentModel->update($request->departmentId, $request->name, $request->ownerId);
        if (!$updated)
            return response()->json(new DefaultResponse(true, 'Error al actualizar la información del departamento'));

        return response()->json(new DefaultResponse(false, 'Información del departamento actualizado con éxito'));
    }

    public function delete(IdRequest $request)
    {
        $deleted = $this->departmentModel->delete($request->departmentId);
        if (!$deleted)
            return response()->json(new DefaultResponse(true, 'Error al dar de baja el departamento'));

        return response()->json(new DefaultResponse(false, 'Departamento dado de baja con éxito'));
    }

    public function getTableAdapter()
    {
        $departments = $this->departmentModel->getTableAdapter();
        if (!$departments)
            return response()->json(new DefaultResponse(true, 'Error al obtener los departamentos'));

        return response()->json(new DefaultResponse(false, 'Departamentos obtenidos con éxito', $departments));
    }

    public function get(IdRequest $request)
    {
        $department = $this->departmentModel->get($request->departmentId);
        if (!$department)
            return response()->json(new DefaultResponse(true, 'Error al obtener el departamento'));

        return response()->json(new DefaultResponse(false, 'Departamento obtenido con éxito', $department));
    }
}
