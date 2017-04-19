<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 14/04/2017
 * Time: 4:54 PM
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
        echo "服务器出错，注册失败，请联系技术人员。<br>";
        return null;
    }
}

function insertData(string $name, $email, $password) {
    if($conn = connectToDB()){
        $sql = "INSERT INTO users (name, email, password)
                    VALUES ('$name', '$email', '$password')";

        // use exec() because no results are returned
        $conn->exec($sql);
        $last_id = $conn->lastInsertId();
        echo "注册成功！<br>";
        $conn = null;
    }
}

//入口
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    insertData($name, $email, $password);
}