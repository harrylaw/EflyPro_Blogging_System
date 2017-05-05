<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>发博文|睿江云EflyPro博客系统</title>

    <!-- Bootstrap核心CSS -->
    <link href="../stylesheets/bootstrap.min.css" rel="stylesheet">

    <!-- 自定义的博客样式表 -->
    <link href="../stylesheets/blog.css" rel="stylesheet">

    <!-- 为了让IE9以下的浏览器支持HTML5元素和media queries，而导入HTML5 shim和Respond.js -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php
    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
    $nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : null;
    $user_type = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;
    if ($user_type != 'a') {
        echo "<script>alert('你没有发博文的权限！即将返回博文广场。'); location.href = 'index.php'; </script>";
    }
?>
<body>
    <nav class="blog-masthead navbar-fixed-top">
        <div class="container">
            <div class="blog-nav-header">
                <a class="blog-nav-brand" href="#">EflyPro博客</a>
            </div>
            <ul class="blog-nav">
                <li class="blog-nav-item"><a href="index.php">博文广场</a></li>
                <li class="blog-nav-item active"><a href="#">发博文</a></li>
                <li class="blog-nav-item"><a href="get_post.php">全文阅读</a></li>
                <li class="blog-nav-item"><a href="#">功能4</a></li>
                <li class="blog-nav-item"><a href="#">关于我们</a></li>
            </ul>
            <ul class="navbar-right">
                <?php
                        echo "<li class='blog-nav-userinfo'><span>管理员 <strong>$nickname</strong> ，欢迎回来！</span></li>";
                        echo "<li class='blog-nav-item'><a href='log_out.php'><span class='glyphicon glyphicon-log-out'></span>注销</a></li>";
                ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="blog-header">
            <h1 class="blog-title">发博文</h1>
            <p id="userTypeInfoPr" class="lead blog-description">
                <?php
                    echo "管理员 <bold>$nickname</bold> ，欢迎使用发博文功能";
                ?>
            </p>
        </div>

        <div class="row">
            <form id="addPostForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-horizontal">
                <div class="form-group">
                    <label for="title" class="control-label col-sm-1">标题：</label>
                    <div class="col-sm-11">
                        <input type="text" id="title" name="title" class="form-control" autofocus="autofocus" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="post_content" class="control-label col-sm-1">内容：</label>
                    <div class="col-sm-11">
                        <textarea id="post_content" name="post_content" rows="20" class="form-control"></textarea>
                    </div>
                </div>
                <input type="submit" id="submit" value="发博文" class="btn btn-default btn-primary col-sm-offset-6" style="margin-bottom: 60px;">
            </form>
        </div>
    </div>

    <footer class="blog-footer">
        <p>版权所有 &copy; EflyPro睿江云 <?php echo date("Y"); ?> </p>
        <p>
            <a href="#">回到顶部</a>
        </p>
    </footer>

    <!-- 为了让页面加载得更快而放在文件底部 -->
    <script src="../scripts/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap核心JavaScript -->
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../scripts/add_post.js"></script>
</body>
</html>
<?php
    use controller\PostController;
    require_once "../controller/PostController.php";

    function test_input(string $data): string {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = str_replace("'", "&apos;", $data);
        return $data;
    }

    //入口
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = test_input($_POST["title"]);
        $content = test_input($_POST["post_content"]);
        $post_controller = PostController::getInstance();

        try {
            $post_controller->post($title, $user_id, $content);
            echo "<script>alert('发博文成功！按确认返回博文广场。'); location.href = 'index.php';</script>";

        } catch (\PDOException $e) {
            //无法连接到数据库
            echo $e;
            //echo "<script>alert('发博文失败！服务器出错，请联系技术人员。')</script>";
        }
    }
?>
