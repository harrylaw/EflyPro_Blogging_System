<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>EflyPro睿江云博客系统</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/index.css"/>
</head>
<?php
    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
    $name = isset($_SESSION["name"]) ? $_SESSION["name"] : null;
    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
    $user_type = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;
?>
<body>
    <nav>
        <ul>
            <li><a href="#">EflyPro睿江云 <span>博客系统</span></a></li>
            <li><a href="#">功能1</a></li>
            <li><a href="#">功能2</a></li>
            <li><a href="#">功能3</a></li>
        </ul>
    </nav>

    <div id="content">
        <p id="userInfoPr">
            <?php
                if (!$user_id) {
                    echo "你还没登录，请 <a href='view/log_in.html'>登录</a> 或 <a href='view/sign_up.html'>注册</a>";
                } else {
                    if ($user_type == "a")
                        echo "管理员 <bold>$name</bold> ，欢迎回来！<a href='view/log_out.php'>注销</a>";
                    else
                        echo "用户 <bold>$name</bold> ，欢迎回来！<a href='view/log_out.php'>注销</a>";
                }
            ?>
        </p>
        <section id="text">
            <h1>云磁盘快照深度详解</h1>
            睿江云快照功能为您提供一次快照无限还原的可能，减少客户误操作需要恢复原始数据的效率和保证。同时，还可通过快照生成新的磁盘，重新使用已备份的数据，并快捷生成新的云实例。
            <br><br><br>
            什么是磁盘快照？
            <br><br><br>
            所谓磁盘快照，就是某一个时间点上某一个磁盘的数据备份。
            <br><br><br>
            您在使用磁盘的过程中，有可能会遇到以下需求：
            <br><br><br>
            ●当您在磁盘上进行数据的写入和存储时，希望使用某块磁盘上某个特点时间的数据作为其他磁盘的基础数据。
            <br><br><br>
            ●云盘（普通云盘、 SSD 云盘）虽然提供了安全的存储方式，确保您所存储的任何内容都不会丢失，但是如果存储在磁盘上的数据本身就是错误的数据，比如由于应用错误导致的数据错误，或者黑客利用您的应用漏洞进行恶意读写，那么就需要其他的机制来保证在您的数据出现问题时，能够恢复到您所期望的数据状态。
            <br><br><br>
            通过快照技术的实现，可以简单高效的满足上述需求。
            <br><br><br>
            ●数据备份：利用自动快照可以自动化的实现云服务器的数据备份；
            <br><br><br>
            ●数据恢复：若因误操作/被攻击等数据丢失时，可通过快照回滚恢复快照时间点的数据；
            <br><br><br>
            ●数据盘克隆：利用快照创建磁盘，可让云服务器以快照时间点的数据进行工作，完整的克隆云服务器上的应用环境配置。
            <br><br><br>
            磁盘快照的类型
            <br><br><br>
            磁盘快照可以分为固定快照和自动快照。
            <br><br><br>
            ●固定快照由您手动创建。您可以根据需要，手动为磁盘创建快照，作为数据备份。
            <br><br><br>
            ●自动快照是睿江云自动为您创建的快照。您需要首先选中需要配置的磁盘，然后再配置自动快照策略应用到磁盘上，系统就会在您设置的时间，自动为该磁盘创建快照。
        </section>
        <footer>版权所有 &copy; EflyPro睿江云 <?php echo date("Y"); ?> </footer>
    </div>
</body>
</html>
