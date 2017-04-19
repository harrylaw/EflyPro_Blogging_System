<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 17/04/2017
 * Time: 5:35 PM
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
        return null;
    }
}

function isEmailTaken(PDO $conn, string $email): bool {
    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = $conn->query($sql);
    $conn = null;
    return (bool) $result->rowCount();
}

//入口
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);

    if ($conn = connectToDB()) {
        if (isEmailTaken($conn, $email))
            echo "TAKEN";
        else
            echo "AVAILABLE";
    } else {
        echo "SERVER_ERROR";
    }
}

