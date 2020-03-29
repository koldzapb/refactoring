<?php


namespace App\DBRepository;


use App\Environment;
use App\Reporting\JsonReporter;
use App\Reporting\ReporterInterface;
use PDO;
use PDOException;

class PDOConnection extends Environment
{
    private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

    protected $con;

    public function connect(ReporterInterface $reporter)

    {
        if ($this->con == NULL) {
            // Create the connection

            try {
                $this->con = new PDO( $this->server, $this->user,$this->pass,$this->options);

            } catch(PDOException $e) {
                throw new NewPDOException(new JsonReporter);

            }
            return $this->con;
        }

    }

}
