<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 20/04/2017
 * Time: 9:14 AM
 */
session_start();
session_unset();
session_destroy();

use controller\UserController;
require_once "../controller/UserController.php";

UserController::getInstance()->logOut();

if (isset($_GET['refer']))
    echo "<script>location.href='" . $_GET['refer'] . "'</script>";
else
    echo "<script>location.href='index.php'</script>";