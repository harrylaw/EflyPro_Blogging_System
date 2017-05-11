<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="EflyPro睿江云博客系统">
    <meta name="author" content="EflyPro睿江云">

    <title>分类阅读 | 睿江云EflyPro博客</title>

    <!-- Bootstrap核心CSS -->
    <link href="../stylesheets/bootstrap.min.css" rel="stylesheet">

    <!-- 自定义的博客样式表 -->
    <link href="../stylesheets/blog.css" rel="stylesheet">
    <link href="../stylesheets/scroll_button.css" rel="stylesheet">

    <!-- 为了让IE9以下的浏览器支持HTML5元素和media queries，而导入HTML5 shim和Respond.js -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php
    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
    $nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : null;
    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
    $user_type = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;
?>
<body>
    <nav class="blog-masthead navbar-fixed-top">
        <div class="container">
            <header class="blog-nav-header">
                <a class="blog-nav-brand" href="index.php">EflyPro博客</a>
            </header>
            <ul class="blog-nav">
                <li class="blog-nav-item"><a href="index.php">博文广场</a></li>
                <li class="blog-nav-item"><a href="get_post.php">全文阅读</a></li>
                <li class="blog-nav-item active"><a href="category_view.php">分类阅读</a></li>
                <?php
                    if ($user_type == 'a') {
                        echo "<li class='blog-nav-item'><a href='add_post.php'>发博文</a></li>";
                    }
                ?>
                <li class="blog-nav-item"><a href="#">关于我们</a></li>
            </ul>
            <ul class="navbar-right">
                <?php
                if (!$user_id) {
                    echo "<li class='blog-nav-item'><a href='sign_up.php?refer=category_view.php'><span class='glyphicon glyphicon-user'></span> 注册</a></li>";
                    echo "<li class='blog-nav-item'><a href='log_in.php?refer=category_view.php'><span class='glyphicon glyphicon-log-in'></span> 登录</a></li>";
                } else {
                    if ($user_type == "a") {
                        echo "<li class='blog-nav-userinfo'><span>管理员 <strong>$nickname</strong> ，欢迎回来！</span></li>";
                    } else {
                        echo "<li class='blog-nav-userinfo'><span>用户 <strong>$nickname</strong> ，欢迎回来！</span></li>";
                    }
                    echo "<li class='blog-nav-item'><a href='log_out.php?refer=category_view.php'><span class='glyphicon glyphicon-log-out'></span> 注销</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>

<!-- 为了让页面加载得更快而放在文件底部 -->
<script src="../scripts/jquery-3.2.1.min.js"></script>
<!-- Bootstrap核心JavaScript -->
<script src="../scripts/bootstrap.min.js"></script>
<!-- 自定义JavaScript -->
<script src="../scripts/scroll_button.js"></script>
</body>
</html>