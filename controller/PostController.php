<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 24/04/2017
 * Time: 11:31 AM
 */

namespace controller;
use model\Post;
require_once("../model/Post.php");


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
}