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

    <title>睿江云EflyPro博客系统</title>

    <!-- Bootstrap核心CSS -->
    <link href="stylesheets/bootstrap.min.css" rel="stylesheet">

    <!-- 自定义的博客样式表 -->
    <link href="stylesheets/blog.css" rel="stylesheet">

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
            <div class="blog-nav-header">
                <a class="blog-nav-brand" href="#">EflyPro博客</a>
            </div>
            <div class="blog-nav">
                <a class="blog-nav-item active" href="#">博文广场</a>
                <a class="blog-nav-item" href="view/add_post.php">发博文</a>
                <a class="blog-nav-item" href="#">功能3</a>
                <a class="blog-nav-item" href="#">功能4</a>
                <a class="blog-nav-item" href="#">关于我们</a>
                <div class="navbar-right">
                    <?php
                        if (!$user_id) {
                            echo "<a href='view/sign_up.html' class='blog-nav-item'><span class='glyphicon glyphicon-user'></span> 注册</a>";
                            echo "<a href='view/log_in.html' class='blog-nav-item'><span class='glyphicon glyphicon-log-in'></span> 登录</a>";
                        } else {
                            if ($user_type == "a") {
                                echo "<span class='blog-nav-userinfo'>管理员 <strong>$nickname</strong> ，欢迎回来！</span>";
                                echo "<a href='view/log_out.php' class='blog-nav-item'><span class='glyphicon glyphicon-log-out'></span>注销</a>";
                            }
                            else {
                                echo "<a class='blog-nav-userinfo'>用户 <strong>$nickname</strong> ，欢迎回来！</a>";
                                echo "<a href='view/log_out.php' class='blog-nav-item'><span class='glyphicon glyphicon-log-out'></span>注销</a>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">

        <div class="blog-header">
            <h1 class="blog-title">EFlyPro睿江云博客</h1>
            <p class="lead blog-description">睿江云粉丝的乐园</p>
        </div>

        <div class="row">

            <div class="col-sm-8 blog-main">

              <div class="blog-post">
                <h2 class="blog-post-title">Sample blog post</h2>
                <p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>

                <p>This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>
                <hr>
                <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
                <blockquote>
                  <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong> ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </blockquote>
                <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                <h2>Heading</h2>
                <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <h3>Sub-heading</h3>
                <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                <pre><code>Example code block</code></pre>
                <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
                <h3>Sub-heading</h3>
                <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                <ul>
                  <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
                  <li>Donec id elit non mi porta gravida at eget metus.</li>
                  <li>Nulla vitae elit libero, a pharetra augue.</li>
                </ul>
                <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>
                <ol>
                  <li>Vestibulum id ligula porta felis euismod semper.</li>
                  <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
                  <li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>
                </ol>
                <p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.</p>
              </div><!-- /.blog-post -->

              <div class="blog-post">
                <h2 class="blog-post-title">Another blog post</h2>
                <p class="blog-post-meta">December 23, 2013 by <a href="#">Jacob</a></p>

                <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
                <blockquote>
                  <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong> ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </blockquote>
                <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
              </div><!-- /.blog-post -->

              <div class="blog-post">
                <h2 class="blog-post-title">New feature</h2>
                <p class="blog-post-meta">December 14, 2013 by <a href="#">Chris</a></p>

                <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                <ul>
                  <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
                  <li>Donec id elit non mi porta gravida at eget metus.</li>
                  <li>Nulla vitae elit libero, a pharetra augue.</li>
                </ul>
                <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>
              </div><!-- /.blog-post -->

              <nav>
                <ul class="pager">
                  <li><a href="#">上一页</a></li>
                  <li><a href="#">下一页</a></li>
                </ul>
              </nav>

            </div><!-- /.blog-main -->

            <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
                <div class="sidebar-module sidebar-module-inset">
                    <h4>关于我们</h4>
                        <p><img width="215px" title="睿江科技" src="image/logo.png" /></p>

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

    </div><!-- /.container -->

    <footer class="blog-footer">
        <p>版权所有 &copy; EflyPro睿江云 <?php echo date("Y"); ?> </p>
        <p>
            <a href="#">回到顶部</a>
        </p>
    </footer>

    <!-- 为了让页面加载得更快而放在文件底部 -->
    <script src="scripts/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap核心JavaScript -->
    <script src="scripts/bootstrap.min.js"></script>
</body>
</html>
