<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 21/04/2017
 * Time: 11:58 AM
 */

namespace controller;
use model\User;
require_once "../model/User.php";
require_once "DBController.php";

class UserController
{
    private static $instance = null;
    private $user;

    private function __construct() {
    }

    public static function getInstance() {
        if (!self::$instance)
            self::$instance = new UserController();
        return self::$instance;
    }

    public function signUp(string $nickname, string $email, string $password, string $user_type): bool{
        $this->user = new User();

        try {
            $conn = DBController::connectToDB();
            $result = $this->user->signUpToDB($conn, $nickname, $email, $password, $user_type);
            $conn = null;
            if ($result) {
                $this->user->writeToSession();
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function logIn(string $email, string $password): bool {
        $this->user = new User();

        try {
            $conn = DBController::connectToDB();
            $result = $this->user->getCorrespondingUserInfoFromDB($conn, $email, $password);
            $conn = null;
            if ($result) {
                $this->user->writeToSession();
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function logOut(){
        unset($this->user);
    }

    public function isNicknameTaken(string $nickname): bool {
        try {
            $conn = DBController::connectToDB();
            $result = User::doesNicknameExistInDB($conn, $nickname);
            $conn = null;
            return $result;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function isEmailTaken(string $email): bool {
        try {
            $conn = DBController::connectToDB();
            $result = User::doesEmailExistInDB($conn, $email);
            $conn = null;
            return $result;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }
}