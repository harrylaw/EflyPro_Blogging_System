<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 14/04/2017
 * Time: 4:54 PM
 */
use controller\UserController;
require_once("../controller/UserController.php");

/**
 * @param string $data
 * @return string
 */
function test_input(string $data): string {
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//入口
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = test_input($_POST["nickname"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $user_type = test_input($_POST["user_type"]);
    $userController = UserController::getInstance();

    try {
        if ($userController->signUp($nickname, $email, $password, $user_type)) {
            echo "注册成功！2秒后自动登录并跳转到主页<br>";
            $url = "../index.php";
            echo "<meta http-equiv='refresh' content='2.0;url=$url'>";
        } else {
            echo "注册失败！此邮箱已被注册，请换一个邮箱再试。<br>返回 <a href='sign_up.html'>注册</a> 页面<br>";
        }
    } catch (PDOException $e) {
        //无法连接到数据库
        echo "注册失败！服务器出错，请联系技术人员。<br>";
    }
}