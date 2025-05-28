<?php

namespace App\Models\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Establece tu nueva contraseña de RendiApps')->view('email_recuperar_pwd', ["email" => $this->email, "token" => $this->token]);
    }
}
