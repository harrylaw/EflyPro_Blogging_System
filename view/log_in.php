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
 * Created by PhpStorm.
 * User: harry
 * Date: 18/04/2017
 * Time: 5:01 PM
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
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $userController = UserController::getInstance();

    try {
        if ($userController->logIn($email, $password)) {
            echo "登录成功！2秒后跳转到主页<br>";
            $url = "../index.php";
            echo "<meta http-equiv='refresh' content='2.0;url=$url'>";
        } else {
            echo "密码错误，请重试！<br>返回 <a href='log_in.html'>登录</a> 页面<br>";
        }
    } catch (PDOException $e) {
        //无法连接到数据库
        echo "注册失败！服务器出错，请联系技术人员。<br>";
    }
}