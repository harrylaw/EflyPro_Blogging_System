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

    <title>全文阅读 | 睿江云EflyPro博客</title>

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
    use controller\PostController;
    use controller\UserController;
    use controller\CommentController;
    use controller\CategoryController;
    require_once "../controller/PostController.php";
    require_once "../controller/UserController.php";
    require_once "../controller/CommentController.php";
    require_once "../controller/CategoryController.php";
    $post_controller = PostController::getInstance();
    $user_controller = UserController::getInstance();
    $comment_controller = CommentController::getInstance();
    $category_controller = CategoryController::getInstance();

    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
    $nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : null;
    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
    $user_type = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;

    if (isset($_GET["post_id"])) {
        $post_id = (int) $_GET["post_id"];
        if ($post_id < 1 || !$post_controller->doesPostExist($post_id)) {
            $post_id = null;
        }
    } else {
        $post_id = 1;
    }
    $categories = $category_controller->readCategories();
?>
<body>
    <nav class="blog-masthead navbar-fixed-top">
        <div class="container">
            <header class="blog-nav-header">
                <a class="blog-nav-brand" href="index.php">EflyPro博客</a>
            </header>
            <ul class="blog-nav">
                <li class="blog-nav-item"><a href="index.php">博文广场</a></li>
                <li class="blog-nav-item active"><a href="get_post.php">全文阅读</a></li>
                <li class="blog-nav-item"><a href="category_view.php">分类阅读</a></li>
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
                        echo "<li class='blog-nav-item'><a href='sign_up.php?refer=get_post.php?post_id=$post_id'><span class='glyphicon glyphicon-user'></span> 注册</a></li>";
                        echo "<li class='blog-nav-item'><a href='log_in.php?refer=get_post.php?post_id=$post_id'><span class='glyphicon glyphicon-log-in'></span> 登录</a></li>";
                    } else {
                        if ($user_type == "a") {
                            echo "<li class='blog-nav-userinfo'><span>管理员 <strong>$nickname</strong> ，欢迎回来！</span></li>";
                        } else {
                            echo "<li class='blog-nav-userinfo'><span>用户 <strong>$nickname</strong> ，欢迎回来！</span></li>";
                        }
                        echo "<li class='blog-nav-item'><a href='log_out.php?refer=get_post.php?post_id=$post_id'><span class='glyphicon glyphicon-log-out'></span> 注销</a></li>";
                    }
                ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <header class="blog-header">
            <h1 class="blog-title">全文阅读</h1>
            <p class="lead blog-description">EFlyPro睿江云博客</p>
        </header>

        <div class="row" id="content">
            <section class="col-sm-8 blog-main">
                <?php
                    if (isset($post_id)) {
                        $post = $post_controller->getPostById($post_id);
                        $title = $post->getTitle();
                        $post_content = $post->getPost_content();
                        $post_author_id = $post->getPost_author_id();
                        $author_nickname = $user_controller->getNicknameById($post_author_id);
                        $post_date = $post->getPost_date();
                        $post_category_id = $post->getPost_category_id();
                        if ($post_category_id) {
                            $post_category_name = $category_controller->getCategory_nameByCategory_id($post_category_id);
                        } else {
                            $post_category_name = "无";
                        }

                        //上下篇导航
                        $last_post_id_and_title = $post_controller->getLastPost_idAndTitle($post_id);
                        $next_post_id_and_title = $post_controller->getNextPost_idAndTitle($post_id);
                        if ($last_post_id = $last_post_id_and_title["post_id"]) {
                            $last_title = $last_post_id_and_title["title"];
                            echo "<p><a href='get_post.php?post_id=$last_post_id'>上一篇: $last_title</a></p>\n";
                        } else {
                            echo "<p>上一篇: 没有上一篇了</p>\n";
                        }
                        if ($next_post_id = $next_post_id_and_title["post_id"]) {
                            $next_title = $next_post_id_and_title["title"];
                            echo "<p><a href='get_post.php?post_id=$next_post_id'>下一篇: $next_title</a></p>\n";
                        } else {
                            echo "<p>下一篇: 没有下一篇了</p>\n";
                        }

                        //打印博文
                        echo "<article class='blog-post'>\n";
                        echo "<h2 class='blog-post-title'>$title</h2>\n\n";
                        if ($post_category_id){
                            echo "<p class='blog-post-meta'>发表时间：$post_date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                . "作者：$author_nickname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类：<a href='category_view.php?category_id=$post_category_id'>$post_category_name</a></p>\n";
                        } else {
                            echo "<p class='blog-post-meta'>发表时间：$post_date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                . "作者：$author_nickname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类：无</p>\n";
                        }
                        echo  $post_content . "\n";
                        echo "</article>\n";
                    }
                ?>

                <section class="comment" id="comment">
                    <?php
                        if(isset($post_id)) {
                            $comments = $comment_controller->readCommentsByPost_id($post_id);
                            if ((bool) $comments) { //有评论时
                                echo "<h4 class='text-center'>评论区</h4>";
                                echo "<hr>";
                                $index = 1;
                                foreach ($comments as $comment) {
                                    $comment_content = $comment->getComment_content();
                                    $comment_author_id = $comment->getComment_author_id();
                                    $comment_date = $comment->getComment_date();
                                    $comment_author_nickname = $user_controller->getNicknameById($comment_author_id);
                                    echo "<div class='blog-comment'>\n";
                                    echo "<p class='blog-comment-meta'>$index" . "楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$comment_author_nickname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$comment_date 评论</p>\n";
                                    echo "<p>". $comment_content ."</p>\n";
                                    echo "</div>\n";
                                    echo "<hr>\n";
                                    $index++;
                                }
                            }
                        }
                    ?>
                    <form id="commentForm" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]);?>" method="post">
                        <div class="form-group">
                            <label for="comment_content">评论框</label>
                            <span id="words_count" class="small control-label" style="float: right">还可以输入：255字</span>
                            <textarea id="comment_content" name="comment_content" rows="5" class="form-control" placeholder="字数限制：255字"></textarea>
                        </div>
                        <input type="submit" id="submit" value="发表评论" class="btn btn-default btn-primary col-sm-offset-5" style="margin-bottom: 60px;">
                    </form>
                    <?php
                        if (!$user_id) {
                            echo "<script>document.getElementById('words_count').style.display = 'none';</script>";
                            echo "<script>document.getElementById('comment_content').disabled = 'disabled';</script>";
                            echo "<script>document.getElementById('comment_content').placeholder = '登录后方可发表评论';</script>";
                            echo "<script>document.getElementById('submit').style.display = 'none';</script>";
                            echo "<p class='text-center small'>现在 <a href='log_in.php?refer=get_post.php?post_id=$post_id&anchor=comment'>登录</a> 或 <a href='sign_up.php?refer=get_post.php?post_id=$post_id&anchor=comment'>注册</a></p>";
                        }
                    ?>
                </section>
            </section><!-- /.blog-main -->

            <aside class="col-sm-3 col-sm-offset-1 blog-sidebar">
                <section class="sidebar-module sidebar-module-inset">
                    <h4>关于我们</h4>
                    <p><img width="215px" title="睿江科技" src="../images/logo.png" /></p>
                    <p><a href="#"><strong>睿江科技研发部</strong></a></p>
                    <p><strong>官方网站：</strong><a href="http://www.eflypro.com/" target="_blank">EflyPro网站</a></p>
                    <p><strong>交流QQ群：</strong><a target="_blank" title="点击申请加入EflyPro官方交流群" href="http://shang.qq.com/wpa/qunwpa?idkey=76e5ce21ff1aab74f9b65b58e88ad87e5dac5a8c7fdc4b0a0b5f26811209190f"> 3373916670</a></p>
                </section>

                <section class="sidebar-module" id="categories_sidebar">
                    <?php
                        require_once "categories_sidebar_maker.php";
                        makeCategories_sidebar($categories);
                    ?>
                </section>

                <section class="sidebar-module">
                    <h4>友情链接</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ul>
                </section>

                <button type="button" class="btn btn-default btn-md scroll-to-top">
                    <span class="glyphicon glyphicon-triangle-top"></span>
                </button>
                <button type="button" class="btn btn-default btn-md scroll-to-bottom">
                    <span class="glyphicon glyphicon-triangle-bottom"></span>
                </button>
            </aside><!-- /.blog-sidebar -->
        </div><!-- /.row -->
        <?php
            //当post_id没意义时
            if (!isset($post_id)) {
                echo "<script>var content_div = document.getElementById('content');\n"
                    . "content_div.parentNode.removeChild(content_div);\n</script>";
                echo "<h4 style='text-align: center; padding-bottom: 250px' class='lead'>您请求的页面不存在，返回 <a href='index.php'>博文广场</a></h4>";
            }
        ?>
    </div><!-- /.container -->

    <footer class="blog-footer">
        <p>版权所有 &copy; EflyPro睿江云 <?php echo date("Y"); ?> </p>
    </footer>

    <!-- 为了让页面加载得更快而放在文件底部 -->
    <script src="../scripts/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap核心JavaScript -->
    <script src="../scripts/bootstrap.min.js"></script>
    <!-- 自定义JavaScript -->
    <script src="../scripts/get_post.js"></script>
    <script src="../scripts/scroll_button.js"></script>
    <!-- 分享按钮 -->
    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"2","bdPos":"right","bdTop":"100"},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>

    <?php
    function test_input(string $data): string {
        $data = trim($data);
        $data = htmlspecialchars($data);
        if (!get_magic_quotes_gpc())
            $data = addslashes($data);
        return $data;
    }

    //入口
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $comment_content = test_input($_POST["comment_content"]);

        try {
            $comment_controller->comment($comment_content, $post_id, $user_id);
            echo "<script>alert('发表评论成功！');</script>";
            echo "<script>location.reload();</script>";
        } catch (\PDOException $e) {
            //无法连接到数据库
            echo "<script>alert('发表评论失败！服务器出错，请联系技术人员。')</script>";
        }
    }
    if (isset($_GET["anchor"]) && $_GET["anchor"] == "comment") {
        echo "<script>$('html, body').scrollTop($(document).height() - $(window).height());</script>";
    }
    ?>
</body>
</html>

