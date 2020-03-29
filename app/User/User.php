<?php


namespace App\User;


use App\DBRepository\UserSQL;
use App\Reporting\ReporterInterface;
use App\Validation\Validation;

class User
{

    private $email;
    private $password;
    private $password2;
    /**
     * @var Validation
     */
    private $validator;

    /**
     * User constructor.
     * @param $email
     * @param $password
     * @param $password2
     * @param Validation $validator
     */
    public function __construct($email, $password, $password2, Validation $validator)
    {
        $this->email = $email;
        $this->password = $password;
        $this->password2 = $password2;
        $this->validator = $validator;

        $this->validator->name('email')->value($this->email)->required()->is_email($this->email);
        $this->validator->name('password')->value($this->password)->required()->min(8)->equal($this->password2);
        $this->validator->name('password2')->value($this->password2)->required()->min(8);


    }

    public function saveNewUser(UserSQL $sql, SendMailToUser $send, ReporterInterface $reporter)
    {

        $sql->getUserEmail($this->email);
        $sql->saveNewUser($this->email, $this->password);
        $send->sendMail($this->email, 'Dobro došli', 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...', 'adm@kupujemprodajem.com');
        $sql->registerNewUser();


        $_SESSION['userId'] = $sql->getUserid();

        $reporter->report([
            'success' => true,
            'userId' => $sql->getUserid()
        ]);

    }
}