<?php


namespace App\Validation;

use App\Reporting\ReporterInterface;

class Validation {


    private $error;
    private $name;
    private $value;
    /**
     * @var ReporterInterface
     */
    private $reporter;

    /**
     * Validation constructor.
     * @param ReporterInterface $reporter
     */
    public function __construct(ReporterInterface $reporter)
    {
        $this->reporter = $reporter;
    }


    public function name($name){

        $this->name = $name;
        return $this;

    }


    public function value($value){

        $this->value = $value;
        return $this;

    }


    public function required(){

        if($this->value != '' && $this->value != null) return $this;

        $this->reporter->report([
            'success' => false,
            'error' => $this->name
        ]);

        exit;

    }


    public function min($length){

        if(is_string($this->value) || strlen($this->value <= $length) ) return $this;

        $this->reporter->report([
            'success' => false,
            'error' => $this->name
        ]);

        exit;

    }


    public function equal($value){

        if($this->value == $value) return $this;

        $this->error = $this->reporter->report([
            'success' => false,
            'error' => $this->name. '_missmatch'
        ]);

        exit;
    }

    public  function is_email($value){

        if(filter_var($value, FILTER_VALIDATE_EMAIL)) return;

        $this->error = $this->reporter->report([
            'success' => false,
            'error' => 'email_format'
        ]);

        exit;

    }


}