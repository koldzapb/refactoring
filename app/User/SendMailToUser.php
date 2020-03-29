<?php


namespace App\User;


class SendMailToUser
{
    public function sendMail($email, $subject, $message, $headers= null){

        mail($email, $subject, $message, $headers);

    }

}