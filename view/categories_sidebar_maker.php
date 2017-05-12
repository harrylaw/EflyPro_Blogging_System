<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 12/05/2017
 * Time: 10:36 AM
 */
    function makeCategories_sidebar(array $categories) {
        echo "<h4>博文分类</h4>\n";
        echo "<ul class='list-unstyled'>\n";

        foreach ($categories as $category) {
            $category_id = $category->getCategory_id();
            $category_name = $category->getCategory_name();
            echo "<li><a href='category_view.php?category_id=$category_id'>$category_name</a></li>\n";
        }

        echo "</ul>\n";
    }