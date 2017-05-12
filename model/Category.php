<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 25/04/2017
 * Time: 3:24 PM
 */

namespace model;


class Category
{
    private $category_id, $category_name;

    public function __construct(int $category_id, string $category_name){
        $this->category_id = $category_id;
        $this->category_name = $category_name;
    }

    public static function readCategoriesFromDB(\PDO $conn): array {
        $sql = "SELECT * FROM categories ORDER BY category_name";

        $result_set = $conn->query($sql);
        $categories_raw = $result_set->fetchAll(\PDO::FETCH_ASSOC);
        return $categories_raw;
    }

    public static function addCategoryToDB(\PDO $conn, string $category_name): bool {
        if (self::doesCategory_nameExistInDB($conn, $category_name)) {
            return false;
        } else {
            $sql = "INSERT INTO categories (category_name)
                    VALUES ('$category_name')";

            // use exec() because no results are returned
            $conn->exec($sql);
            return true;
        }
    }

    public static function doesCategory_idExistInDB(\PDO $conn, int $category_id): bool {
        $sql = "SELECT * FROM categories WHERE category_id = $category_id";

        $result_set = $conn->query($sql);
        return (bool) $result_set->rowCount();
    }

    public static function doesCategory_nameExistInDB(\PDO $conn, string $category_name): bool {
        $sql = "SELECT * FROM categories WHERE category_name ='$category_name'";

        $result_set = $conn->query($sql);
        return (bool) $result_set->rowCount();
    }

    public function getCategory_id(): int {
        return $this->category_id;
    }

    public function getCategory_name(): string {
        return $this->category_name;
    }
}