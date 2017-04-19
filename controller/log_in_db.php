<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 14/04/2017
 * Time: 4:54 PM
 */

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

function getCorrespondingUser_id(string $email, $password): string {
    if ($conn = connectToDB()) {
        $sql = "SELECT user_id from users WHERE email='$email' and password='$password'";

        $result = $conn -> query($sql);
        if ($result -> rowCount() == 0) {
            return "";
        } else {
            echo $result -> nextRowset() . "<br>";
            return $result -> rowCount();
        }
    }
}

//入口
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $user_id = getCorrespondingUser_id($email, $password);
    if ($user_id == "") {
        echo "密码错误，请重试！<br>返回 <a href='../view/log_in.html'>登录</a> 页面";
    } else {
        echo "登录成功！<br>" . $user_id;
    }
}