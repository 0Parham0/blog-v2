<?php

require_once __DIR__ . "/Model.php";

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addUser($fName, $lName, $name_as_author, $email, $password)
    {
        $sql = "INSERT INTO users (first_name, last_name, name_as_author, email, password)
                VALUES (:fName, :lName, :name_as_author, :email, :password)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":fName", $fName, PDO::PARAM_STR);
        $statement->bindParam(":lName", $lName, PDO::PARAM_STR);
        $statement->bindParam(":name_as_author", $name_as_author);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", $password);
        $statement->execute();
    }

    public function isExist($key, $value)
    {
        $sql = "SELECT * 
                FROM users
                WHERE $key = :_value";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":_value", $value);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
