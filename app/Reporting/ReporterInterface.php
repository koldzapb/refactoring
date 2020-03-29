<?php


namespace App\Reporting;


interface ReporterInterface
{
    public function report($variables = []);
}