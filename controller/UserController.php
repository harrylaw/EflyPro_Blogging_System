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

class UserController
{
    private static $instance = null;
    private $user;

    private function __construct()
    {
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new UserController();
        }
        return self::$instance;
    }

    public function signUp(string $name, $email, $password, $user_type): bool{
        $this->user = new User();
        if ($this->user->signUpToDB($name, $email, $password, $user_type)) {
            $this->user->writeToSession();
            return true;
        } else {
            return false;
        }
    }

    public function logIn(string $email, $password): bool {
        $this->user = new User();
        if ($this->user->getCorrespondingUserInfoFromDB($email, $password)) {
            $this->user->writeToSession();
            return true;
        } else {
            return false;
        }
    }

    public function logOut(){
        unset($this->user);
    }
}