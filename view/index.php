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

    <title>博文广场|睿江云EflyPro博客系统</title>

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
    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
    $user_type = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;
    $current_page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
    use controller\PostController;
    require_once "../controller/PostController.php";
    $post_controller = PostController::getInstance();
    $total_posts = $post_controller->countPosts();
    $posts_on_each_page = 3;
    $total_pages = ceil($total_posts/$posts_on_each_page);
    //当current_page有意义时
    if ($current_page > 0 && $current_page <= $total_pages) {
        $posts_on_current_page = ($current_page == $total_pages) ? ($total_posts - ($current_page - 1) * 3) : 3;
    }
?>
<body>
    <nav class="blog-masthead navbar-fixed-top">
        <div class="container">
                <div class="blog-nav-header">
                    <a class="blog-nav-brand" href="#">EflyPro博客</a>
                </div>
                <ul class="blog-nav">
                    <li class="blog-nav-item active"><a href="#">博文广场</a></li>
                    <li class="blog-nav-item"><a href="add_post.php">发博文</a></li>
                    <li class="blog-nav-item"><a href="get_post.php">全文阅读</a></li>
                    <li class="blog-nav-item"><a href="#">功能4</a></li>
                    <li class="blog-nav-item"><a href="#">关于我们</a></li>
                </ul>
                <ul class="navbar-right">
                    <?php
                        if (!$user_id) {
                            echo "<li class='blog-nav-item'><a href='sign_up.php'><span class='glyphicon glyphicon-user'></span> 注册</a></li>";
                            echo "<li class='blog-nav-item'><a href='log_in.php'><span class='glyphicon glyphicon-log-in'></span> 登录</a></li>";
                        } else {
                            if ($user_type == "a") {
                                echo "<li class='blog-nav-userinfo'><span>管理员 <strong>$nickname</strong> ，欢迎回来！</span></li>";
                                echo "<li class='blog-nav-item'><a href='log_out.php'><span class='glyphicon glyphicon-log-out'></span>注销</a></li>";
                            }
                            else {
                                echo "<li class='blog-nav-userinfo'><span>用户 <strong>$nickname</strong> ，欢迎回来！</span></li>";
                                echo "<li class='blog-nav-item'><a href='log_out.php'><span class='glyphicon glyphicon-log-out'></span>注销</a></li>";
                            }
                        }
                    ?>
                </ul>
        </div>
    </nav>

    <div class="container">

        <div class="blog-header">
            <h1 class="blog-title">EFlyPro睿江云博客</h1>
            <p class="lead blog-description">睿江云粉丝的乐园</p>
        </div>

        <div class="row" id="content">
            <div class="col-sm-8 blog-main">
                <?php
                    use controller\UserController;
                    require_once "../controller/UserController.php";
                    if (isset($posts_on_current_page)) {
                        $post_controller->readPosts($current_page, $posts_on_each_page, $posts_on_current_page);
                        for ($i = 0; $i < $posts_on_current_page; $i++) {
                            $post = $post_controller->getPost($i);
                            $post_id = $post->getPost_id();
                            $title = $post->getTitle();
                            $post_content = $post->getPost_content();
                            $striped_and_extracted_content = strip_tags(substr($post_content, 0, 800), "<h1><h2><h3><h4><h5><h6>");
                            $post_author_id = $post->getPost_author_id();
                            $user_controller = UserController::getInstance();
                            $author_nickname = $user_controller->getNicknameById($post_author_id);
                            $post_date = $post->getPost_date();
                            echo "<hr>\n";
                            echo "<div class='blog-post'>\n";
                            echo "<h2 class='blog-post-title'>$title</h2>\n\n";
                            echo "<p class='blog-post-meta'>发表时间：$post_date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作者：$author_nickname</p>\n";
                            //echo  $post_content . "\n";
                            echo  "<p>" . $striped_and_extracted_content . "\n</p>\n";
                            echo "<a href='get_post.php?post_id=$post_id'>阅读全文</a>\n";
                            echo "</div>\n";
                            echo "<hr>\n";
                        }
                    }
                ?>

              <nav><!-- 翻页器 -->
                  <ul class="pagination">
                      <?php
                        //当current_page有意义时
                        if (isset($posts_on_current_page)) {
                            require_once "pagination_maker.php";
                            makePagination($current_page, $total_pages);
                        }
                      ?>
                  </ul>
              </nav>

            </div><!-- /.blog-main -->

            <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
                <div class="sidebar-module sidebar-module-inset">
                    <h4>关于我们</h4>
                        <p><img width="215px" title="睿江科技" src="../image/logo.png" /></p>

                        <p><a href="#"><strong>睿江科技研发部</strong></a></p>

                        <p><strong>官方网站：</strong><a href="http://www.eflypro.com/" target="_blank">EflyPro网站</a></p>

                        <p><strong>交流QQ群：</strong><a target="_blank" title="点击申请加入EflyPro官方交流群" href="http://shang.qq.com/wpa/qunwpa?idkey=76e5ce21ff1aab74f9b65b58e88ad87e5dac5a8c7fdc4b0a0b5f26811209190f"> 3373916670</a></p>
                </div>
                <div class="sidebar-module">
                    <h4>分类</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">March 2014</a></li>
                        <li><a href="#">February 2014</a></li>
                        <li><a href="#">January 2014</a></li>
                        <li><a href="#">December 2013</a></li>
                        <li><a href="#">November 2013</a></li>
                        <li><a href="#">October 2013</a></li>
                        <li><a href="#">September 2013</a></li>
                        <li><a href="#">August 2013</a></li>
                        <li><a href="#">July 2013</a></li>
                        <li><a href="#">June 2013</a></li>
                        <li><a href="#">May 2013</a></li>
                        <li><a href="#">April 2013</a></li>
                    </ol>
                </div>
                <div class="sidebar-module">
                    <h4>友情链接</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
            </div><!-- /.blog-sidebar -->
        </div><!-- /.row -->
        <?php
            //当current_page没意义时
            if (!isset($posts_on_current_page)) {
                echo "<script>document.getElementById('content').style.display = 'none';</script>";
                echo "<h4 style='text-align: center; padding-bottom: 250px' class='lead'>您请求的页面不存在，返回 <a href='index.php'>博文广场</a></h4>";
            }
        ?>
    </div><!-- /.container -->

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
</body>
</html>
