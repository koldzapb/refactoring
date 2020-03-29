<?php


namespace App\DBRepository;


use App\Reporting\JsonReporter;
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
    /**
     * @var \PDO|void
     */
    private $conn;


    public function __construct(ReporterInterface $reporter)
    {
        $this->connection = new PDOConnection;
        $this->conn = $this->connection->connect(new JsonReporter);
        $this->reporter = $reporter;
    }


    public function getUserEmail($email){

        $statement = $this->conn->prepare('SELECT * FROM user WHERE email = :email');
        $statement->execute(array('email' => $email));
        if ($statement->fetchColumn() > 0){
            $this->reporter->report([
                'success' => false,
                'error' => 'user_already_exists'
            ]);exit;
        }

    }
    public function saveNewUser($email, $password){

        $statement = $this->conn->prepare('INSERT INTO user SET email = :email, password = :password');
        $statement->execute(array('email' => $email, 'password' => md5($password)));

        $this->setUserid($this->conn->lastInsertId());

    }

    public function registerNewUser(){

        $statement = $this->conn->prepare('INSERT INTO user_log SET action = "register", user_id = :userid, log_time = NOW()');
        $statement->execute(array('userid' => $this->getUserid()));

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