<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 08/05/2017
 * Time: 3:54 PM
 */

namespace controller;
use model\Comment;
require_once "../model/Comment.php";
require_once "DBController.php";


class CommentController
{
    private static $instance = null;
    private $comments = array();

    private function __construct() {
    }

    public static function getInstance() {
        if (!self::$instance)
            self::$instance = new CommentController();
        return self::$instance;
    }

    public function comment(string $comment_content, int $comment_post_id, int $comment_author_id) {
        try {
            $conn = DBController::connectToDB();
            Comment::addCommentToDB($conn, $comment_content, $comment_post_id, $comment_author_id);
            $conn = null;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function readCommentsByPost_id(int $comment_post_id): array {
        try {
            $conn = DBController::connectToDB();
            $comments_raw = Comment::readCommentsByPost_idFromDB($conn, $comment_post_id);
            $conn = null;

            if (!(bool) $comments_raw) { //数组为空时
                return array();
            } else {
                foreach ($comments_raw as $comment_raw) {
                    $comment_id = (int) $comment_raw["comment_id"];
                    $comment_content = stripslashes($comment_raw["comment_content"]);
                    $comment_post_id = (int) $comment_raw["comment_post_id"];
                    $comment_author_id = (int) $comment_raw["comment_author_id"];
                    $comment_date = $comment_raw["comment_date"];
                    $comment = new Comment($comment_id, $comment_content, $comment_post_id, $comment_author_id, $comment_date);
                    array_push($this->comments, $comment);
                }
                return $this->comments;
            }
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }
}