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
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $user_type = test_input($_POST["user_type"]);

    $userController = UserController::getInstance();
    if ($userController->signUp($name, $email, $password, $user_type)) {
        echo "注册成功！2秒后自动登录并跳转到主页面<br>";
        $url = "../index.php";
        echo "<meta http-equiv='refresh' content='2.0;url=$url'>";
    } else {
        echo "注册失败！服务器出错，请联系技术人员。";
    }
}