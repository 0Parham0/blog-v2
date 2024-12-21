<?php

try {
    $config = (require_once __DIR__ . "/../config/config.php")["sql"];

    $serverName = $config["serverName"];
    $username = $config["username"];
    $password = $config["password"];

    $conn = new PDO("mysql:host=$serverName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents(ROOT_PATH . "database/createDbAndTables.sql");
    $conn->exec($sql);
    echo "Successful: Database and tables created";
} catch (PDOException $pdoE) {
    echo "Failed: " . $pdoE->getMessage();
}
