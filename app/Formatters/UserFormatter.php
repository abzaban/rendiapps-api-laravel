<?php

namespace App\Formatters;

use App\Domain\User;

class UserFormatter
{
    private $mongoFormatter;

    function __construct()
    {
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function toDomain($data)
    {
        if (!is_array($data)) {
            $data->permissions['enterprises'] = $this->mongoFormatter->objectIdsToStringIds($data->permissions['enterprises']);
            $data->permissions['stations'] = $this->mongoFormatter->objectIdsToStringIds($data->permissions['stations']);
            $data->permissions['modules'] = $this->permissionModulesToRaw($data->permissions['modules']);

            return new User(
                $this->mongoFormatter->objectIdToStringId($data->_id),
                $data->firstName,
                $data->lastName,
                $data->address,
                $data->email,
                $data->image,
                $data->username,
                $data->password,
                $data->permissions
            );
        }

        $dataFormatted = [];
        foreach ($data as $user) {
            $user = (object) $user;

            $user->permissions['enterprises'] = $this->mongoFormatter->objectIdsToStringIds($user->permissions['enterprises']);
            $user->permissions['stations'] = $this->mongoFormatter->objectIdsToStringIds($user->permissions['stations']);
            $user->permissions['modules'] = $this->permissionModulesToRaw($user->permissions['modules']);

            $dataFormatted[] = new User(
                $this->mongoFormatter->objectIdToStringId($user->_id),
                $user->firstName,
                $user->lastName,
                $user->address,
                $user->email,
                $user->image,
                $user->username,
                $user->password,
                $user->permissions
            );
        }
        return $dataFormatted;
    }

    public function rawModulesToPermission($modules)
    {
        $modulesFormatted = [];
        foreach ($modules as $module)
            $modulesFormatted[] = [
                'moduleId' => $this->mongoFormatter->stringIdToObjectId($module['moduleId']),
                'roleId' => $module['roleId']
            ];

        return $modulesFormatted;
    }

    public function permissionModulesToRaw($modules)
    {
        $modulesFormatted = [];
        foreach ($modules as $module)
            $modulesFormatted[] = [
                'moduleId' => $this->mongoFormatter->objectIdToStringId($module['moduleId']),
                'roleId' => $module['roleId']
            ];

        return $modulesFormatted;
    }

    public function permissionModulesToIds($modules)
    {
        $ids = [];
        foreach ($modules as $module)
            $ids[] = $this->mongoFormatter->objectIdToStringId($module['moduleId']);

        return $ids;
    }
}
