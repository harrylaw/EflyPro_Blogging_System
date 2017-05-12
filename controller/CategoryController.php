<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 11/05/2017
 * Time: 4:43 PM
 */

namespace controller;
use model\Category;
require_once "../model/Category.php";
require_once "DBController.php";


class CategoryController
{
    private static $instance = null;
    private $categories = array();

    private function __construct() {
    }

    public static function getInstance() {
        if (!self::$instance)
            self::$instance = new CategoryController();
        return self::$instance;
    }

    public function readCategories(): array {
        try {
            $conn = DBController::connectToDB();
            $categories_raw = Category::readCategoriesFromDB($conn);
            $conn = null;

            if (!(bool) $categories_raw) {
                return array();
            } else {
                foreach ($categories_raw as $category_raw) {
                    $category_id = (int) $category_raw["category_id"];
                    $category_name = stripslashes($category_raw["category_name"]);
                    $category = new Category($category_id, $category_name);
                    array_push($this->categories, $category);
                }
                return $this->categories;
            }
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function getCategory_nameByCategory_id(int $category_id): string {
        foreach ($this->categories as $category) {
            if ($category->getCategory_id() == $category_id) {
                return $category->getCategory_name();
            }
        }
        return "";
    }

    public function doesCategory_idExist(int $category_id): bool {
        try {
            $conn = DBController::connectToDB();
            $result = Category::doesCategory_idExistInDB($conn, $category_id);
            $conn = null;
            return $result;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function createCategory(string $category_name): bool {
        try {
            $conn = DBController::connectToDB();
            $result = Category::addCategoryToDB($conn, $category_name);
            $conn = null;
            return $result;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }
}