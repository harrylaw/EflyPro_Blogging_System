<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 24/04/2017
 * Time: 11:31 AM
 */

namespace model;


use controller\DBController;
require_once "../controller/DBController.php";

class Post
{
    private $post_id, $title, $post_author_id, $post_content, $post_date;

    public function __construct(int $post_id, string $title, int $post_author_id, string $post_content, string $post_date){
        $this->post_id = $post_id;
        $this->title = $title;
        $this->post_author_id = $post_author_id;
        $this->post_content = $post_content;
        $this->post_date = $post_date;
    }

    public static function addPostToDB(\PDO $conn, string $title, int $post_author_id, string $post_content) {
        $sql = "INSERT INTO posts (title, post_author_id, post_content)
                VALUES ('$title', $post_author_id, '$post_content')";

        // use exec() because no results are returned
        $conn->exec($sql);
    }

    public static function readPostsFromDB(\PDO $conn, int $offset, int $posts_on_current_page): array {
        $sql = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $offset, $posts_on_current_page";

        $result_set = $conn->query($sql);
        $posts_array_raw = $result_set->fetchAll(\PDO::FETCH_ASSOC);
        return $posts_array_raw;
    }

    public static function countPosts(\PDO $conn): int {
        $sql = "SELECT COUNT(post_id) FROM posts";

        $result_set = $conn->query($sql);
        $posts_count_array = $result_set->fetch(\PDO::FETCH_ASSOC);
        return $posts_count_array["COUNT(post_id)"];
    }

    public static function getPostById(\PDO $conn, int $post_id): Post {
        $sql = "SELECT * FROM posts WHERE post_id = $post_id";

        $result_set = $conn->query($sql);
        $post_raw = $result_set->fetch(\PDO::FETCH_ASSOC);
        $title = $post_raw["title"];
        $post_author_id = (int) $post_raw["post_author_id"];
        $post_content = htmlspecialchars_decode($post_raw["post_content"]);
        $post_date = $post_raw["post_date"];
        $post = new Post($post_id, $title, $post_author_id, $post_content, $post_date);
        return $post;
    }

    public static function doesPostExistInDB(\PDO $conn, int $post_id): bool {
        $sql = "SELECT * FROM posts WHERE post_id = $post_id";

        $result_set = $conn->query($sql);
        return (bool) $result_set->rowCount();
    }

    public function getPost_id(): int {
        return $this->post_id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getPost_author_id(): int {
        return $this->post_author_id;
    }

    public function getPost_content(): string {
        return $this->post_content;
    }

    public function getPost_date(): string {
        return $this->post_date;
    }
}