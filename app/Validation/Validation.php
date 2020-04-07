<?php


namespace App\Validation;

use App\DBRepository\UserSQL;
use App\Reporting\ReporterInterface;

class Validation
{


    private $error;
    private $name;
    private $value;
    /**
     * @var ReporterInterface
     */
    private $reporter;
    /**
     * @var UserSQL
     */
    private $sql;

    /**
     * Validation constructor.
     * @param ReporterInterface $reporter
     * @param UserSQL $sql
     */
    public function __construct(ReporterInterface $reporter, UserSQL $sql)
    {
        $this->reporter = $reporter;
        $this->sql = $sql;
    }


    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {

        $this->name = $name;
        return $this;

    }


    /**
     * @param $value
     * @return $this
     */
    public function value($value)
    {

        $this->value = $value;
        return $this;

    }


    /**
     * @return $this
     */
    public function required()
    {

        if ($this->value != '' && $this->value != null) return $this;

        $this->reporter->report([
            'success' => false,
            'error' => $this->name
        ]);

        exit;

    }


    /**
     * @param $length
     * @return $this
     */
    public function min($length)
    {

        if (is_string($this->value) && strlen($this->value) >= $length) return $this;

        $this->reporter->report([
            'success' => false,
            'error' => $this->name
        ]);

        exit;

    }


    /**
     * @param $value
     * @return $this
     */
    public function equal($value)
    {

        if ($this->value == $value) return $this;

        $this->error = $this->reporter->report([
            'success' => false,
            'error' => $this->name . '_missmatch'
        ]);

        exit;
    }

    /**
     * @param $value
     */
    public function is_email($value)
    {

        if (filter_var($value, FILTER_VALIDATE_EMAIL)) return;

        $this->error = $this->reporter->report([
            'success' => false,
            'error' => 'email_format'
        ]);

        exit;

    }

    /**
     * @param $value
     */
    public function is_user_exists($value)
    {

        if (!$this->sql->getUserEmail($value)) return;

        $this->error = $this->reporter->report([
            'success' => false,
            'error' => 'user_already_exists'
        ]);

        exit;

    }


}