<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 21/04/2017
 * Time: 11:58 AM
 */

namespace controller;
use model\User;
require_once("../model/User.php");
require_once("DBController.php");

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

    public function signUp(string $name, string $email, string $password, string $user_type): bool{
        $this->user = new User();

        try {
            $conn = DBController::connectToDB();
            if ($this->user->signUpToDB($conn, $name, $email, $password, $user_type)) {
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
            if ($this->user->getCorrespondingUserInfoFromDB($conn, $email, $password)) {
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

    public function isEmailTaken(string $email): bool {
        try {
            $conn = DBController::connectToDB();
            return User::doesEmailExistInDB($conn, $email);
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }
}