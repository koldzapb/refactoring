<?php


namespace App\DBRepository;


use App\Environment;
use App\Reporting\ReporterInterface;
use PDO;
use PDOException;

class PDOConnection extends Environment implements DBConnectionInterface
{
    protected $con;
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    /**
     * @var ReporterInterface
     */
    private $reporter;


    /**
     * PDOConnection constructor.
     * @param ReporterInterface $reporter
     */
    public function __construct(ReporterInterface $reporter)
    {
        $this->reporter = $reporter;
    }


    /**
     * @return PDO
     */
    public function connect()

    {
        if ($this->con == NULL) {
            // Create the connection

            try {
                $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);

            } catch (PDOException $e) {
                throw new NewPDOException($this->reporter);

            }
            return $this->con;
        }

    }

    /**
     * @param $sql
     * @param bool $fetchData
     * @return mixed
     */
    public function runQuery($sql, $fetchData = false)

    {
        $query = $this->con->exec($sql);
        if ($fetchData) {
            $query->setFetchMode(PDO::FETCH_ASSOC);
        }
        return $query;
    }

    /**
     * @param $sql
     * @param $variables
     * @param bool $fetchData
     * @return mixed
     */
    public function runPrepareStatmentQuery($sql, $variables, $fetchData = false)
    {

        $statement = $this->con->prepare($sql);
        $statement->execute($variables);

        if ($fetchData == true) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    /**
     * @return mixed
     */
    public function getLastInsertedId()
    {
        return $this->con->lastInsertId();
    }


}
