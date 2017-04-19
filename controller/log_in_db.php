<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 14/04/2017
 * Time: 4:54 PM
 */
session_start();

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

function connectToDB() {
    $serverName = "localhost:3306";
    $username = "root";
    $password = "harrylaw";
    $dbName = "EflyProBloggingSystem";

    try {
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e)
    {
        echo "服务器出错，登录失败，请联系技术人员。";
        return null;
    }
}

function getCorrespondingUserInfo(string $email, $password): array {
    if ($conn = connectToDB()) {
        $sql = "SELECT user_id, name from users WHERE email='$email' and password='$password'";

        $result = $conn -> query($sql);
        if ($result -> rowCount() == 0) {
            return array("user_id"=>"0");
        } else {
            return $result -> fetch(PDO::FETCH_ASSOC);
        }
    }
}

//入口
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $user_info_array = getCorrespondingUserInfo($email, $password);
    
    if ($user_info_array["user_id"] == 0) {
        echo "密码错误，请重试！<br>返回 <a href='../view/log_in.html'>登录</a> 页面<br>";
    } else {
        $_SESSION["user_id"] = (int) $user_info_array["user_id"];
        $_SESSION["name"] = $user_info_array["name"];
        $_SESSION["email"] = $email;
        echo "登录成功！2秒后跳转到主页面<br>";
        $url = "../index.php";
        echo "<meta http-equiv='refresh' content='2.0;url=$url'>";
    }
}