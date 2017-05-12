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
    <link href="../favicon.ico" rel="icon" type="image/x-icon">

    <title>登录 | 睿江云EflyPro博客</title>

    <!-- Bootstrap核心CSS -->
    <link href="../stylesheets/bootstrap.min.css" rel="stylesheet">

    <!-- 自定义的登录样式表 -->
    <link href="../stylesheets/blog.css" rel="stylesheet">
    <link href="../stylesheets/form.css" rel="stylesheet">

    <!-- 为了让IE9以下的浏览器支持HTML5元素和media queries，而导入HTML5 shim和Respond.js -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="blog-masthead navbar-fixed-top">
        <div class="container">
            <header class="blog-nav-header">
                <a class="blog-nav-brand" href="index.php">EflyPro博客</a>
            </header>
            <ul class="blog-nav">
                <li class="blog-nav-item"><a href="index.php">博文广场</a></li>
                <li class="blog-nav-item"><a href="get_post.php">全文阅读</a></li>
                <li class="blog-nav-item"><a href="category_view.php">分类阅读</a></li>
                <li class="blog-nav-item"><a href="#">关于我们</a></li>
            </ul>
            <ul class="navbar-right">
                <?php
                    echo "<li class='blog-nav-item'><a href='sign_up.php'><span class='glyphicon glyphicon-user'></span> 注册</a></li>";
                    echo "<li class='blog-nav-item active'><a href='log_in.php'><span class='glyphicon glyphicon-log-in'></span> 登录</a></li>";
                ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <form id="logInForm" method="post" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" class="form-login">
            <h2 class="form-login-heading">登录</h2>
            <div id="emailField" class="form-group has-feedback">
                <label for="email" class="sr-only">邮箱</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="邮箱地址" autofocus>
                <span id="emailInfoIcon" class="form-control-feedback glyphicon"></span>
                <p id="emailInfo" class="control-label"></p>
            </div>
            <div id="passwordField" class="form-group has-feedback">
                <label for="password" class="sr-only">密码</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="密码（区分大小写）">
                <span id="passwordInfoIcon" class="form-control-feedback glyphicon"></span>
                <p id="passwordInfo" class="control-label"></p>
            </div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" id="submit" name="submit" value="登录">
        </form>
    </div> <!-- /container -->

    <!-- 为了让页面加载得更快而放在文件底部 -->
    <script src="../scripts/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap核心JavaScript -->
    <script src="../scripts/bootstrap.min.js"></script>
    <!-- 自定义JavaScript -->
    <script src="../scripts/log_in.js"></script>

    <?php
    use controller\UserController;
    require_once "../controller/UserController.php";

    /**
     * Created by PhpStorm.
     * User: harry
     * Date: 18/04/2017
     * Time: 5:01 PM
     * @param string $data
     * @return string
     */
    function test_input(string $data): string {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //入口
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);
        $user_controller = UserController::getInstance();

        try {
            if ($user_controller->logIn($email, $password)) {
                echo "<script>$('#logInForm').css('display', 'none');</script>";
                if (isset($_GET['refer'])){
                    echo "<h4 style='text-align: center; padding-top: 60px;'>登录成功！1.5秒后跳转到登录前页面</h4>";
                    if (isset($_GET['anchor'])){
                        echo "<script>setTimeout(function() {location.href='" . $_GET['refer'] . "&anchor=" . $_GET['anchor'] . "'}, 1500)</script>";
                    } else {
                        echo "<script>setTimeout(function() {location.href='" . $_GET['refer'] . "'}, 1500)</script>";
                    }
                } else {
                    echo "<h4 style='text-align: center; padding-top: 60px;'>登录成功！1.5秒后跳转到博文广场</h4>";
                    $url = "index.php";
                    echo "<meta http-equiv='refresh' content='1.5; url=$url'>";
                }
            } else {
                echo "<script>$('#logInForm').css('display', 'none');</script>";
                echo "<h4 style='text-align: center; padding-top: 60px;'>密码错误，请重试</h4>";
                echo "<h4 style='text-align: center;'>返回 <a href='log_in.php'>登录</a> 页面</h4>";
            }
        } catch (PDOException $e) {
            //无法连接到数据库
            echo "<script>$('#logInForm').css('display', 'none');</script>";
            echo "<h4 style='text-align: center; padding-top: 60px;'>登录失败！服务器出错，请联系技术人员。</h4>";
        }
    }
    ?>
</body>
</html>