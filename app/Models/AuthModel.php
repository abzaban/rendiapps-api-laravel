<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;

class AuthModel
{
    public function loginWithEmail($authValue)
    {
        return preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $authValue);
    }

    public function validatePassword($requestPassword, $userPassword)
    {
        return Hash::check($requestPassword, $userPassword);
    }

    public function encryptPassword($password)
    {
        return Hash::make($password);
    }
}
