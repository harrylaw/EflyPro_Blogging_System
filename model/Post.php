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
    private $post_id, $title, $author_id, $content, $tag_id, $category_id, $post_date;

    public function __construct(){
    }

    public function addPost(string $title, int $author_id, string $content){
        $this->title = $title;
        $this->author_id = $author_id;
        $this->content = $content;
    }


}