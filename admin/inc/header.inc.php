<?php

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>
    <title><?php echo $template['title'] ?></title>
    <link rel="shortcut icon" href="css/bbs32.png">
    <?php
        foreach ($template['css'] as $val) {
            echo "<link rel='stylesheet' type='text/css' href='{$val}?v=1.11'>";
        }
    ?>
</head>

<body>
<div id="top">
    <div class="logo">
        onlineShop
    </div>
    <div class="login_info">
        <a target="_blank" href="../index.php" style="color:#fff;">网站首页</a>&nbsp;|&nbsp;
        管理员：<?php echo $_SESSION['manage']['name']?> <a style="color:#fff;" href="logout.php">[注销]</a>
    </div>
</div>

<div id="sidebar">
    <ul>
        <li>
            <div class="small_title">系统</div>
            <ul class="child">
                <li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='index.php'){echo 'class="current"';}?> href="index.php">系统信息</a></li>
                <li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='manage.php'){echo 'class="current"';}?> href="manage.php">管理员</a></li>
                <li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='manage_add.php'){echo 'class="current"';}?> href="manage_add.php">添加管理员</a></li>
            </ul>
        </li>

        <li>
            <div class="small_title">员工</div>
            <ul class="child">
                <li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='employee.php'){echo 'class="current"';}?> href="employee.php">员工信息</a></li>
                <li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='employee_add.php'){echo 'class="current"';}?> href="employee_add.php">添加员工</a></li>
                <?php
                if (basename($_SERVER['SCRIPT_NAME']) == 'employee_update.php') {
                    echo '<li><a href="" class="current">修改员工信息</a></li>';
                }
                ?>
            </ul>
        </li>



        <li>
            <div class="small_title">商品管理</div>
            <ul class="child">
                <li><a href="dirInfo.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'dirInfo.php') {echo "current";} ?>">目录列表</a></li>
                <?php
                    if (basename($_SERVER['SCRIPT_NAME']) == 'dirInfo_update.php') {
                        echo '<li><a href="" class="current">修改目录</a></li>';
                    }
                ?>
                <li><a href="dirInfo_add.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'dirInfo_add.php') {echo "current";} ?>">添加目录</a></li>
                <li><a href="subDirInfo.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'subDirInfo.php') {echo "current";} ?>">子目录列表</a></li>
                <?php
                    if (basename($_SERVER['SCRIPT_NAME']) == 'son_module_update.php') {
                        echo '<li><a href="" class="current">修改子目录</a></li>';
                    }
                ?>
                <li><a href="subDirInfo_add.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'subDirInfo_add.php') {echo "current";} ?>">添加子目录</a></li>
                <li><a href="product.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'product.php') {echo "current";} ?>">商品列表</a></li>
                <li><a href="product_add.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'product_add.php') {echo "current";} ?>">添加商品</a></li>
                <?php
                if (basename($_SERVER['SCRIPT_NAME']) == 'product_update.php') {
                    echo '<li><a href="" class="current">修改商品</a></li>';
                }
                ?>
            </ul>
        </li>





        <li>
            <div class="small_title">用户管理</div>
            <ul class="child">
                <li><a href="user_list.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'user_list.php') {echo "current";} ?>">用户列表</a></li>
                <li><a href="user_search.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'user_search.php') {echo "current";} ?>">搜索用户</a></li>
            </ul>
        </li>

        <li>
            <div class="small_title">仓库管理</div>
            <ul class="child">
                <li><a href="warehouse.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'warehouse.php') {echo "current";} ?>">仓库列表</a></li>
                <li><a href="warehouse_add.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'warehouse_add.php') {echo "current";} ?>">添加仓库</a></li>
                <?php
                    if (basename($_SERVER['SCRIPT_NAME']) == 'warehouse_update.php') {
                        echo '<li><a href="" class="current">修改仓库信息</a></li>';
                    }
                ?>
            </ul>
        </li>

        <li>
            <div class="small_title">订单</div>
            <ul class="child">
                <li><a href="orderDetail.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'orderDetail.php') {echo "current";} ?>">交易记录</a></li>
                <li><a href="resource_add.php" class="<?php if (basename($_SERVER['SCRIPT_NAME']) == 'resource_add.php') {echo "current";} ?>">添加库存</a></li>
<!--                --><?php
//                if (basename($_SERVER['SCRIPT_NAME']) == 'resource_update.php') {
//                    echo '<li><a href="" class="current">修改资源</a></li>';
//                }
//                ?>
            </ul>
        </li>

    </ul>
</div>
