<?php


namespace App\Reporting;


class JsonReporter implements ReporterInterface
{

    public function report($variables = [])
    {
        echo json_encode([
            $variables
        ]);
    }
}