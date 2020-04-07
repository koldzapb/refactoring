<?php


namespace App\DBRepository;


use App\Reporting\ReporterInterface;

class UserSQL
{
    /**
     * @var PDOConnection
     */
    private $connection;

    private $userid;
    /**
     * @var ReporterInterface
     */
    private $reporter;


    public function __construct(ReporterInterface $reporter, DBConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->connection->connect();
        $this->reporter = $reporter;
    }


    /**
     * @param $email
     * @return mixed
     */
    public function getUserEmail($email)
    {

        $query = 'SELECT * FROM user WHERE email = :email';
        $variables = ['email' => $email];
        return $this->connection->runPrepareStatmentQuery($query, $variables, true);

    }

    /**
     * @param $email
     * @param $password
     */
    public function saveNewUser($email, $password)
    {

        $query = 'INSERT INTO user SET email = :email, password = :password';
        $variables = ['email' => $email, 'password' => md5($password)];
        $this->connection->runPrepareStatmentQuery($query, $variables);

        $this->setUserid($this->connection->getLastInsertedId());

    }


    public function registerNewUser()
    {
        $query = 'INSERT INTO user_log SET action = "register", user_id = :userid, log_time = NOW()';
        $variables = ['userid' => $this->getUserid()];
        $this->connection->runPrepareStatmentQuery($query, $variables);
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

}