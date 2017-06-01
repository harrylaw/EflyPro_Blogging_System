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
    public static function connectToDB(): \PDO {
        $serverName = "localhost";
        //$serverName = "121.201.44.207";
        $username = "root";
        $password = "harrylaw";
        //$password = "121.201.44.207";
        $dbName = "EflyProBloggingSystem";

        try {
            $conn = new \PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }
}