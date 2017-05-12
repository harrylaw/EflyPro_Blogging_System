<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 12/05/2017
 * Time: 3:04 PM
 */
use controller\CategoryController;
require_once "../controller/CategoryController.php";

/**
 * @param string $data
 * @return string
 */
function test_input(string $data): string {
    $data = trim($data);
    $data = htmlspecialchars($data);
    if (!get_magic_quotes_gpc())
        $data = addslashes($data);
    return $data;
}

//入口
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = test_input($_POST["category_name"]);
    $category_controller = CategoryController::getInstance();
    try {
        if ($category_controller->createCategory($category_name))
            echo "SUCCEED";
        else
            echo "FAILED";
    } catch (PDOException $e) {
        //无法连接到数据库
        echo "SERVER_ERROR";
    }
}