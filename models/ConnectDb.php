<?php

class ConnectDb
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        try {
            $config = (require_once __DIR__ . "/../config/config.php")["sql"];
            $serverName = $config["serverName"];
            $username = $config["username"];
            $password = $config["password"];
            $dbName = "blogProjectDb";

            $this->conn = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $pdoE) {
            echo "Connection failed: " . $pdoE->getMessage();
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
