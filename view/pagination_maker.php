<?php

/**
 * Created by PhpStorm.
 * User: harry
 * Date: 03/05/2017
 * Time: 5:22 PM
 * @param int $current_page
 * @param int $total_pages
 */
function makePagination(int $current_page, int $total_pages) {
    echo "<li><a href='" . $_SERVER["SCRIPT_NAME"] . "?page=1'>首页</a></li>";

    //确定某种情况下的翻页器的起始页和结束页
    if ($total_pages >= 5) {
        if ($total_pages - $current_page < 2) {
            $start_page = $total_pages - 4;
            $end_page = $total_pages;

        } elseif ($current_page - 1 < 2) {
            $start_page = 1;
            $end_page = 5;
        } else {
            $start_page = $current_page - 2;
            $end_page = $current_page + 2;
        }
    } else { //total_pages < 5
            $start_page = 1;
            $end_page = $total_pages;
    }

    //根据确定的起始页和结束页打印出该情况下的翻页器
    if ($start_page != 1) {
        echo "<li class='disabled'><a>...</a></li>";
    }
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            echo "<li class='active'><a href='" . $_SERVER["SCRIPT_NAME"] . "?page=$i'>$i</a></li>";
            continue;
        }
        echo "<li><a href='" . $_SERVER["SCRIPT_NAME"] . "?page=$i'>$i</a></li>";
    }
    if ($end_page != $total_pages) {
        echo "<li class='disabled'><a>...</a></li>";
    }
    echo "<li><a href='" . $_SERVER["SCRIPT_NAME"] . "?page=$total_pages'>末页</a></li>";
}

