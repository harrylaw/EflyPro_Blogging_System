<?php

/**
 * Created by PhpStorm.
 * User: harry
 * Date: 21/04/2017
 * Time: 11:25 AM
 */

namespace model;
use controller\DBController;
require_once("../controller/DBController.php");

class User
{
    private $user_id, $name, $email, $password, $user_type, $reg_date;

    public function __construct() {
    }

    public function signUpToDB(string $name, $email, $password, $user_type): bool {
        if($conn = DBController::connectToDB()) {
            $sql = "INSERT INTO users (name, email, password, user_type)
                    VALUES ('$name', '$email', '$password', '$user_type')";

            // use exec() because no results are returned
            $conn->exec($sql);
            $last_id = $conn->lastInsertId();

            $this->user_id = (int) $last_id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->user_type = $user_type;
            $this->reg_date = $this->getReg_dateFromDB($conn);
            $conn = null;
            return true;
        } else {
            return false;
        }
    }

    public function writeToSession() {
        session_start();
        $_SESSION["user_id"] = $this->user_id;
        $_SESSION["name"] = $this->name;
        $_SESSION["email"] = $this->email;
        $_SESSION["user_type"] = $this->user_type;
    }

    private function getReg_dateFromDB(\PDO $conn): string {
        $sql = "SELECT reg_date FROM users WHERE user_id = $this->user_id";

        $result = $conn->query($sql);
        $reg_date = $result->fetch(\PDO::FETCH_ASSOC)["reg_date"];
        return $reg_date;
    }

    function getCorrespondingUserInfoFromDB(string $email, $password): bool {
        if ($conn = DBController::connectToDB()) {
            $sql = "SELECT user_id, name, user_type, reg_date from users WHERE email='$email' and password='$password'";

            $result = $conn -> query($sql);
            $conn = null;
            if ($result -> rowCount() == 0) {
                return false;
            } else {
                $user_info_array = $result -> fetch(\PDO::FETCH_ASSOC);

                $this->user_id = (int) $user_info_array["user_id"];
                $this->name = $user_info_array["name"];
                $this->email = $email;
                $this->password = $password;
                $this->user_type = $user_info_array["user_type"];
                $this->reg_date = $user_info_array["reg_date"];
                return true;
            }
        } else {
            return false;
        }
    }
}