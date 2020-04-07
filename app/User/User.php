<?php


namespace App\User;


use App\DBRepository\UserSQL;
use App\Reporting\ReporterInterface;
use App\Validation\Validation;

class User
{

    /**
     * @var UserSQL
     */
    public $sql;
    private $email;
    private $password;
    private $password2;
    /**
     * @var Validation
     */
    private $validator;
    /**
     * @var SendMailToUser
     */
    private $send;
    /**
     * @var ReporterInterface
     */
    private $reporter;

    /**
     * User constructor.
     * @param UserSQL $sql
     * @param SendMailToUser $send
     * @param ReporterInterface $reporter
     */
    public function __construct(UserSQL $sql, SendMailToUser $send, ReporterInterface $reporter)
    {
        $this->sql = $sql;
        $this->send = $send;
        $this->reporter = $reporter;
    }


    public function saveNewUser()
    {

        $this->sql->saveNewUser($this->email, $this->password);
        $this->send->sendMail($this->email);
        $this->sql->registerNewUser();


        $_SESSION['userId'] = $this->sql->getUserid();

        $this->reporter->report([
            'success' => true,
            'userId' => $this->sql->getUserid()
        ]);

    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword2()
    {
        return $this->password2;
    }

    /**
     * @param mixed $password2
     */
    public function setPassword2($password2)
    {
        $this->password2 = $password2;
    }
}