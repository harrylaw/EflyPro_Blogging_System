<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>发博文</title>
</head>
<?php
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : null;
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
$user_type = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;
?>
<body>
<h1>发帖</h1>
<form id="addPostForm" action="">
    <input type="text">
    <input type="text">
</form>
</body>
</html>