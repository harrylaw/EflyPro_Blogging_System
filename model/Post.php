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
    private $post_id, $title, $author_id, $post_content, $post_date;

    public function __construct(){
    }

    public static function addPostToDB(\PDO $conn, string $title, int $author_id, string $post_content){
        $sql = "INSERT INTO posts (title, author_id, post_content)
                VALUES ('$title', $author_id, '$post_content')";

        // use exec() because no results are returned
        $conn->exec($sql);
    }
}