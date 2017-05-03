<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 24/04/2017
 * Time: 11:31 AM
 */

namespace controller;
use model\Post;
require_once "../model/Post.php";
require_once "DBController.php";


class PostController
{
    private static $instance = null;
    private $post;

    private function __construct() {
    }

    public static function getInstance() {
        if (!self::$instance)
            self::$instance = new PostController();
        return self::$instance;
    }

    public function post(string $title, int $author_id, string $post_content) {
        try {
            $conn = DBController::connectToDB();
            Post::addPostToDB($conn, $title, $author_id, $post_content);
            $conn = null;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }
}