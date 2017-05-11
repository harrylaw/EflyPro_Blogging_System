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

    public function getCategory_id(): int {
        return $this->category_id;
    }

    public function getCategory_name(): string {
        return $this->category_name;
    }
}