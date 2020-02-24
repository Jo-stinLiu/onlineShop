<?php

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $template['title'] ?></title>
    <link rel="shortcut icon" href="css/bbs32.png">
    <?php
        foreach ($template['css'] as $val) {
            echo "<link rel='stylesheet' type='text/css' href='{$val}?v=1.20'/>";
        }
    ?>
</head>
<body>

<div class="header_wrap">
    <div id="header" class="auto">
        <div class="logo">onlineShop</div>

        <?php
        if ($member_id) {
$note=<<<DD
            <div class="username">
                <a href="logout.php">退出</a>
		        <a style="color:#fff;">&nbsp;|&nbsp;</a>
		        <a href="member.php?id={$member_id}">{$_COOKIE['username']}</a>
		        <a style="color:#fff;">&nbsp;|&nbsp;</a>
		        <a href="shoppingList.php">购物车</a>
            </div>
DD;
            echo $note;
        }
        else {
$note=<<<DD
            <div class="login">
                <a href="login.php">登录</a>
                &nbsp;
                <a href="register.php">注册</a>
            </div>
DD;
            echo $note;
        }
        ?>
    </div>

    <div id="navi" class="auto">
        <div class="nav">
            <a href="index.php" <?php echo basename($_SERVER['SCRIPT_NAME']) == "index.php" ? "class='hover'" : "" ?> >首页</a>
            <?php
            $query = "select * from dirInfo";
            $result = execute($conn, $query);
            while ($data = mysqli_fetch_assoc($result)) {
                $url = "section.php?name={$data['dirName']}";
                $tem = $_GET['name'] == $data['dirName'] ? 'class=hover' : '';
                $html = "<a href='section.php?name={$data['dirName']}' {$tem}>{$data['dirName']}</a>";
                echo $html;
            }
            ?>
        </div>

        <div class="search">
            <form action="search.php" method="get">
                <input type="text" class="keyword" name="keyword" value="<?php if(isset($_GET['keyword'])) echo $_GET['keyword']?>" placeholder="输入你想搜索的内容">
                <input type="submit" class="submit" name="submit" value="">
            </form>
        </div>


    </div>

</div>

<div class="place-holder"></div>