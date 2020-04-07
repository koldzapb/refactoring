<?php


namespace App\User;


class SendMailToUser
{
    /**
     * @var EmailData
     */
    private $data;

    /**
     * SendMailToUser constructor.
     * @param EmailData $data
     */
    public function __construct(EmailData $data)
    {
        $this->data = $data;
    }

    /**
     * @param $email
     */
    public function sendMail($email)
    {
        mail($email, $this->data->getSubject(), $this->data->getMessage(), $this->data->getHeaders());
    }

}