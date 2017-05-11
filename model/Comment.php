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

    public function __construct(int $comment_id, string $comment_content, int $comment_post_id, int $comment_author_id, string $comment_date)
    {
        $this->comment_id = $comment_id;
        $this->comment_content = $comment_content;
        $this->comment_post_id = $comment_post_id;
        $this->comment_author_id = $comment_author_id;
        $this->comment_date = $comment_date;
    }

    public static function addCommentToDB(\PDO $conn, string $comment_content, int $comment_post_id, int $comment_author_id) {
        $sql = "INSERT INTO comments (comment_content, comment_post_id, comment_author_id)
                VALUES ('$comment_content', $comment_post_id, $comment_author_id)";

        // use exec() because no results are returned
        $conn->exec($sql);
    }

    public static function readCommentsByPost_idFromDB(\PDO $conn, int $comment_post_id): array {
        $sql = "SELECT * FROM comments WHERE comment_post_id = $comment_post_id ORDER BY comment_id";

        $result_set = $conn->query($sql);
        $comments_raw = $result_set->fetchAll(\PDO::FETCH_ASSOC);
        return $comments_raw;
    }

    public function getComment_id(): int {
        return $this->comment_id;
    }

    public function getComment_content(): string {
        return $this->comment_content;
    }

    public function getComment_post_id(): int {
        return $this->comment_post_id;
    }

    public function getComment_author_id(): int {
        return $this->comment_author_id;
    }

    public function getComment_date(): string {
        return $this->comment_date;
    }
}