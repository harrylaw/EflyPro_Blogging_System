<?php

/**
 * Created by PhpStorm.
 * User: harry
 * Date: 21/04/2017
 * Time: 11:25 AM
 */

namespace model;


class User
{
    private $user_id, $nickname, $email, $password, $user_type, $reg_date;

    public function __construct() {
    }

    public function signUpToDB(\PDO $conn, string $nickname, string $email, string $password, string $user_type): bool {
        if (self::doesEmailExistInDB($conn, $email) || self::doesNicknameExistInDB($conn, $nickname)) {
            return false;
        } else {
            $sql = "INSERT INTO users (nickname, email, password, user_type)
                    VALUES ('$nickname', '$email', '$password', '$user_type')";

            // use exec() because no results are returned
            $conn->exec($sql);

            $this->user_id = (int) $conn->lastInsertId();
            $this->nickname = $nickname;
            $this->email = $email;
            $this->password = $password;
            $this->user_type = $user_type;
            $this->reg_date = $this->getReg_dateFromDB($conn);
            return true;
        }
    }

    private function getReg_dateFromDB(\PDO $conn): string {
        $sql = "SELECT reg_date FROM users WHERE user_id = $this->user_id";

        $result = $conn->query($sql);
        $reg_date = $result->fetch(\PDO::FETCH_ASSOC)["reg_date"];
        return $reg_date;
    }

    public function writeToSession() {
        session_start();
        $_SESSION["user_id"] = $this->user_id;
        $_SESSION["nickname"] = $this->nickname;
        $_SESSION["email"] = $this->email;
        $_SESSION["user_type"] = $this->user_type;
    }

    public function getCorrespondingUserInfoFromDB(\PDO $conn, string $email, string $password): bool {
        $sql = "SELECT user_id, nickname, password, user_type, reg_date from users
                WHERE email = '$email' and password = '$password'";

        $result = $conn -> query($sql);
        if ($result -> rowCount() == 0) {
            return false;
        } else {
            $user_info_array = $result -> fetch(\PDO::FETCH_ASSOC);

            if ($password != $user_info_array["password"]) {
                //密码大小写不对应
                return false;
            }
            $this->user_id = (int) $user_info_array["user_id"];
            $this->nickname = $user_info_array["nickname"];
            $this->email = $email;
            $this->password = $password;
            $this->user_type = $user_info_array["user_type"];
            $this->reg_date = $user_info_array["reg_date"];
            return true;
        }
    }

    public static function doesNicknameExistInDB(\PDO $conn, string $nickname): bool {
        $sql = "SELECT * FROM users WHERE nickname = '$nickname'";

        $result = $conn->query($sql);
        return (bool) $result->rowCount();
    }

    public static function doesEmailExistInDB(\PDO $conn, string $email): bool {
        $sql = "SELECT * FROM users WHERE email = '$email'";

        $result = $conn->query($sql);
        return (bool) $result->rowCount();
    }
}