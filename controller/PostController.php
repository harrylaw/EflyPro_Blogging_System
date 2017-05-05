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
    private $posts_array;

    private function __construct() {
    }

    public static function getInstance() {
        if (!self::$instance)
            self::$instance = new PostController();
        return self::$instance;
    }

    public function post(string $title, int $post_author_id, string $post_content) {
        try {
            $conn = DBController::connectToDB();
            Post::addPostToDB($conn, $title, $post_author_id, $post_content);
            $conn = null;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function countPosts(): int {
        try {
            $conn = DBController::connectToDB();
            $posts_count = Post::countPosts($conn);
            $conn = null;
            return $posts_count;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }


    public function readPosts(int $current_page, int $posts_on_each_page, int $posts_on_current_page) {
        try {
            $conn = DBController::connectToDB();
            $offset = ($current_page - 1) * $posts_on_each_page;
            $posts_array_raw = Post::readPostsFromDB($conn, $offset, $posts_on_current_page);
            $conn = null;

            for ($i=0; $i < $posts_on_current_page; $i++) {
                $post_id = (int) $posts_array_raw[$i]["post_id"];
                $title = $posts_array_raw[$i]["title"];
                $post_author_id = (int) $posts_array_raw[$i]["post_author_id"];
                $post_content = htmlspecialchars_decode($posts_array_raw[$i]["post_content"]);
                $post_date = $posts_array_raw[$i]["post_date"];
                $post = new Post($post_id, $title, $post_author_id, $post_content, $post_date);
                $this->posts_array[$i] = $post;
            }
            //return $this->posts_array;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function getPost(int $index) {
        return $this->posts_array[$index];
    }

    public function getPostById(int $post_id) {
        try {
            $conn = DBController::connectToDB();
            $post = Post::getPostById($conn, $post_id);
            $conn = null;
            return $post;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }

    public function doesPostExist(int $post_id):bool {
        try {
            $conn = DBController::connectToDB();
            $result = Post::doesPostExistInDB($conn, $post_id);
            $conn = null;
            return $result;
        } catch (\PDOException $e) {
            //无法连接到数据库
            throw $e;
        }
    }
}