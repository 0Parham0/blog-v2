<?php

abstract class Model
{
    protected $connection;

    public function __construct()
    {
        require_once __DIR__ . "/ConnectDb.php";
        $db = ConnectDb::getInstance();
        $this->connection = $db->getConnection();
    }
}
