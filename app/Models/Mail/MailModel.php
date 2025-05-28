<?php

namespace App\Models\Mail;

use Exception;
use Illuminate\Support\Facades\Mail;
use App\Models\Mail\RecoverPasswordEmail;

class MailModel
{
    public function send($email, $token)
    {
        try {
            return Mail::to($email)->send(new RecoverPasswordEmail($email, $token)) == null;
        } catch (Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }
}
