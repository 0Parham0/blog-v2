<?php

require_once __DIR__ . "/../models/User.php";

class UserController
{
    public function __construct()
    {
        if (isset($_SESSION["id"])) {
            header("Location: dashboard");
        }
    }

    public function showSignup()
    {
        require_once __DIR__ . "/../views/signup.php";
    }

    public function showLogin()
    {
        require_once __DIR__ . "/../views/login.php";
    }

    public function signup()
    {
        $fName = isset($_POST["fName"]) ? $_POST["fName"] : "";
        $lName = isset($_POST["lName"]) ? $_POST["lName"] : "";
        $nameAsAuthor = isset($_POST["nameAsAuthor"]) ? $_POST["nameAsAuthor"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $conPassword = isset($_POST["conPassword"]) ? $_POST["conPassword"] : "";

        $errors = self::signupValidation($fName, $lName, $nameAsAuthor, $email, $password, $conPassword);
        if (count($errors) > 0) {
            require_once __DIR__ . "/../views/signup.php";
        } else {
            $userModel = new User();
            $userModel->addUser($fName, $lName, $nameAsAuthor, $email, password_hash($password, PASSWORD_DEFAULT));

            require_once __DIR__ . "/../views/login.php";
        }
    }

    public function login()
    {
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";

        $errors = self::loginValidation($email, $password);
        if (count($errors) > 0) {
            require_once __DIR__ . "/../views/login.php";
        } else {
            $userModel = new User();
            $user = $userModel->isExist("email", $email);

            $_SESSION["id"] = $user["id"];
            $_SESSION["name"] = $user["first_name"] . " " . $user["last_name"];

            header("Location: dashboard");
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("location: home");
        exit();
    }

    private function signupValidation($fName, $lName, $nameAsAuthor, $email, $password, $conPassword)
    {
        $errors = [];
        $userModel = new User();

        if (!preg_match("/^[a-zA-Z\s]+$/", $fName)) {
            array_push($errors, "first name is not in the right format");
        } else if (strlen($fName) > 50) {
            array_push($errors, "first name cannot exceed 50 characters");
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $lName)) {
            array_push($errors, "last name is not in the right format");
        } else if (strlen($lName) > 50) {
            array_push($errors, "last name cannot exceed 50 characters");
        }

        if (!preg_match('/^[a-zA-Z0-9\s_!?]+$/', $nameAsAuthor)) {
            array_push($errors, "name as author is not in the right format");
        } else if ($userModel->isExist("name_as_author", $nameAsAuthor)) {
            array_push($errors, "name as author already exists in the system");
        } else if (strlen($nameAsAuthor) > 100) {
            array_push($errors, "name as author cannot exceed 100 characters");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "email is not in the right format");
        } else if ($userModel->isExist("email", $email)) {
            array_push($errors, "you have already signed up with this email");
        } else if (strlen($email) > 80) {
            array_push($errors, "email cannot exceed 80 characters");
        }

        if (($password != $conPassword)) {
            array_push($errors, "password and confirm password are not the same");
        } else if (strlen($password) > 255) {
            array_push($errors, "password cannot exceed 255 characters");
        } else if (strlen($password) < 8) {
            array_push($errors, "password cannot be shorter than 8 characters");
        }

        return $errors;
    }

    private function loginValidation($email, $password)
    {
        $errors = [];
        $userModel = new User();

        if (!($user = $userModel->isExist("email", $email))) {
            array_push($errors, "email does not exist");
        } else {
            if (!password_verify($password, $user["password"])) {
                array_push($errors, "password is wrong");
            }
        }

        return $errors;
    }
}