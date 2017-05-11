<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 24/04/2017
 * Time: 11:31 AM
 */

namespace model;


class Post
{
    private $post_id, $title, $post_author_id, $post_content, $post_date, $post_category_id;

    public function __construct(int $post_id, string $title, int $post_author_id, string $post_content, string $post_date, int $post_category_id){
        $this->post_id = $post_id;
        $this->title = $title;
        $this->post_author_id = $post_author_id;
        $this->post_content = $post_content;
        $this->post_date = $post_date;
        $this->post_category_id = $post_category_id;
    }

    public static function addPostToDB(\PDO $conn, string $title, int $post_author_id, string $post_content, int $post_category_id) {
        if ($post_category_id) {
            $sql = "INSERT INTO posts (title, post_author_id, post_content, post_category_id)
                VALUES ('$title', $post_author_id, '$post_content', $post_category_id)";
        } else {
            $sql = "INSERT INTO posts (title, post_author_id, post_content)
                VALUES ('$title', $post_author_id, '$post_content')";
        }

        // use exec() because no results are returned
        $conn->exec($sql);
    }

    public static function readPostsFromDB(\PDO $conn, int $offset, int $posts_on_current_page): array {
        $sql = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $offset, $posts_on_current_page";

        $result_set = $conn->query($sql);
        $posts_raw = $result_set->fetchAll(\PDO::FETCH_ASSOC);
        return $posts_raw;
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
        $title = stripslashes($post_raw["title"]);
        $post_author_id = (int) $post_raw["post_author_id"];
        $post_content = htmlspecialchars_decode(stripslashes($post_raw["post_content"]));
        $post_date = $post_raw["post_date"];
        $post_category_id = (int) $post_raw["post_category_id"];
        $post = new Post($post_id, $title, $post_author_id, $post_content, $post_date, $post_category_id);
        return $post;
    }

    public static function doesPostExistInDB(\PDO $conn, int $post_id): bool {
        $sql = "SELECT * FROM posts WHERE post_id = $post_id";

        $result_set = $conn->query($sql);
        return (bool) $result_set->rowCount();
    }

    public static function getLastPost_idAndTitleFromDB(\PDO $conn, int $post_id): array {
        $sql = "SELECT post_id, title FROM posts WHERE post_id < $post_id ORDER BY post_id DESC LIMIT 1";

        $result_set = $conn->query($sql);
        if ($result_set->rowCount()) {
            $result_raw = $result_set->fetch(\PDO::FETCH_ASSOC);
            $last_post_id = (int) $result_raw["post_id"];
            $last_title = stripslashes($result_raw["title"]);
            return array("post_id" => $last_post_id, "title" => $last_title);
        } else {
            return array("post_id" => 0);
        }
    }

    public static function getNextPost_idAndTitleFromDB(\PDO $conn, int $post_id): array {
        $sql = "SELECT post_id, title FROM posts WHERE post_id > $post_id ORDER BY post_id LIMIT 1";

        $result_set = $conn->query($sql);
        if ($result_set->rowCount()) {
            $result_raw = $result_set->fetch(\PDO::FETCH_ASSOC);
            $next_post_id = (int) $result_raw["post_id"];
            $next_title = stripslashes($result_raw["title"]);
            return array("post_id" => $next_post_id, "title" => $next_title);
        } else {
            return array("post_id" => 0);
        }
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

    public function getPost_category_id(): int {
        return $this->post_category_id;
    }
}