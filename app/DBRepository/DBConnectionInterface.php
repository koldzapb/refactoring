<?php


namespace App\DBRepository;


interface DBConnectionInterface
{
    public function connect();

    public function runQuery($sql);

    public function runPrepareStatmentQuery($sql, $variables);

    public function getLastInsertedId();


}