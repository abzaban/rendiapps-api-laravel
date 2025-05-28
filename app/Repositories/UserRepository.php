<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function save($session, $firstName, $lastName, $address, $email, $username, $password, $permissions, $timestamp)
    {
        return DB::collection('user')->insert(
            [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'address' => $address,
                'email' => $email,
                'image' => null,
                'username' => $username,
                'password' => $password,
                'permissions' => $permissions,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'deleted_at' => null
            ],
            [
                'session' => $session
            ]
        );
    }

    public function getAll()
    {
        return DB::collection('user')->whereNull('deleted_at')->get()->toArray();
    }

    public function update($id, $firstName, $lastName, $address, $permissions, $timestamp)
    {
        return DB::collection('user')->where('_id', $id)->whereNull('deleted_at')->update([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'address' => $address,
            'permissions' => $permissions,
            'updated_at' => $timestamp
        ]);
    }

    public function delete($session, $id, $timestamp)
    {
        return DB::collection('user')->where('_id', $id)->update(
            ['deleted_at' => $timestamp],
            ['session' => $session]
        );
    }

    public function get($id)
    {
        return DB::collection('user')->where('_id', $id)->whereNull('deleted_at')->first();
    }

    public function getByEmail($email)
    {
        return DB::collection('user')->where('email', $email)->whereNull('deleted_at')->first();
    }

    public function getByUsername($username)
    {
        return DB::collection('user')->where('username', $username)->whereNull('deleted_at')->first();
    }

    public function updatePassword($session, $id, $password, $timestamp)
    {
        return DB::collection('user')->where('_id', $id)->whereNull('deleted_at')->update(
            [
                'password' => $password,
                'updated_at' => $timestamp
            ],
            [
                'session' => $session
            ]
        );
    }

    public function getStations($id)
    {
        return DB::collection('user')->where('_id', $id)->whereNull('deleted_at')->first()['permissions']['stations'];
    }

    public function getModules($id)
    {
        return DB::collection('user')->where('_id', $id)->whereNull('deleted_at')->first()['permissions']['modules'];
    }
}
