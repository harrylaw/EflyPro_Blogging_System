<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 17/04/2017
 * Time: 5:35 PM
 */
use controller\UserController;
require_once "../controller/UserController.php";

/**
 * @param string $data
 * @return string
 */
function test_input(string $data): string {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

//入口
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["query"] == "nickname") {
        $nickname = test_input($_POST["nickname"]);
        $user_controller = UserController::getInstance();

        try {
            if ($user_controller->isNicknameTaken($nickname))
                echo "TAKEN";
            else
                echo "AVAILABLE";
        } catch (PDOException $e) {
            //无法连接到数据库
            echo "SERVER_ERROR";
        }
    }
    if ($_POST["query"] == "email") {
        $email = test_input($_POST["email"]);
        $user_controller = UserController::getInstance();

        try {
            if ($user_controller->isEmailTaken($email))
                echo "TAKEN";
            else
                echo "AVAILABLE";
        } catch (PDOException $e) {
            //无法连接到数据库
            echo "SERVER_ERROR";
        }
    }
}