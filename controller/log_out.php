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
echo "<script>location.href='../index.php'</script>";