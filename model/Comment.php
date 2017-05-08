<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 05/05/2017
 * Time: 9:19 AM
 */

namespace model;


class Comment
{
    private $comment_id, $comment_content, $comment_post_id, $comment_author_id, $comment_date;

    public function __construct()
    {
    }

    public static function addCommentToDB(\PDO $conn, string $comment_content, int $comment_post_id, int $comment_author_id) {
        $sql = "INSERT INTO comments (comment_content, comment_post_id, comment_author_id)
                VALUES ('$comment_content', $comment_post_id, $comment_author_id)";

        // use exec() because no results are returned
        $conn->exec($sql);
    }
}