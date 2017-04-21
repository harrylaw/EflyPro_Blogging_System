<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 21/04/2017
 * Time: 12:15 PM
 */

namespace controller;


class DBController
{
    public static function connectToDB() {
        $serverName = "localhost:3306";
        $username = "root";
        $password = "harrylaw";
        $dbName = "EflyProBloggingSystem";

        try {
            $conn = new \PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(\PDOException $e)
        {
            //服务器出错
            return null;
        }
    }
}