<?php


namespace App\DBRepository;


use App\Reporting\ReporterInterface;
use PDOException;

class NewPDOException extends PDOException
{

    /**
     * NewPDOException constructor.
     * @param ReporterInterface $reporter
     */
    public function __construct(ReporterInterface $reporter)
    {
        $reporter->report([
            'success' => false,
            'error' => 'DB_error'
        ]);
        exit;
    }

}