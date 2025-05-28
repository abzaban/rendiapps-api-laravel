<?php

namespace App\Models;

use App\Repositories\UserRepository;

use App\Formatters\UserFormatter;
use App\Formatters\MongoDBFormatter;

class UserModel
{
    private $userRepository, $userFormatter, $mongoFormatter;

    function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->userFormatter = new UserFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function save($session, $firstName, $lastName, $address, $email, $username, $password, $permissions)
    {
        $this->mongoFormatter->stringDateToTimestamp(now());
        $permissionsFormatted = [
            'enterprises' => $this->mongoFormatter->stringIdsToObjectIds($permissions['enterprises']),
            'stations' => $this->mongoFormatter->stringIdsToObjectIds($permissions['stations']),
            'modules' => $this->userFormatter->rawModulesToPermission($permissions['modules']),
        ];
        return $this->userRepository->save(
            $session,
            $firstName,
            $lastName,
            $address,
            $email,
            $username,
            $password,
            $permissionsFormatted,
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function getAll()
    {
        return $this->userFormatter->toDomain($this->userRepository->getAll());
    }

    public function update($id, $firstName, $lastName, $address, $permissions)
    {
        $permissionsFormatted = [
            'enterprises' => $this->mongoFormatter->stringIdsToObjectIds($permissions['enterprises']),
            'stations' => $this->mongoFormatter->stringIdsToObjectIds($permissions['stations']),
            'modules' => $this->userFormatter->rawModulesToPermission($permissions['modules']),
        ];
        return $this->userRepository->update(
            $id,
            $firstName,
            $lastName,
            $address,
            $permissionsFormatted,
            $this->mongoFormatter->stringDateToTimestamp(now())
        );
    }

    public function delete($session, $id)
    {
        return $this->userRepository->delete($session, $id, $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function get($id)
    {
        $user = $this->userRepository->get($this->mongoFormatter->stringIdToObjectId($id));
        return $user ? $this->userFormatter->toDomain((object) $user) : null;
    }

    public function getByEmail($email)
    {
        $user = $this->userRepository->getByEmail($email);
        return $user ? $this->userFormatter->toDomain((object) $user) : null;
    }

    public function getByUsername($username)
    {
        $user = $this->userRepository->getByUsername($username);
        return $user ? $this->userFormatter->toDomain((object) $user) : null;
    }

    public function updatePassword($session, $id, $password)
    {
        return $this->userRepository->updatePassword($session, $id, $password, $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function getStations($id)
    {
        return $this->userRepository->getStations($this->mongoFormatter->stringIdToObjectId($id));
    }

    public function getModulesIds($id)
    {
        return $this->userFormatter->permissionModulesToIds($this->userRepository->getModules($this->mongoFormatter->stringIdToObjectId($id)));
    }
}
