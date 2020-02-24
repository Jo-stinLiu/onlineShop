<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.inc.php';

$template['title'] = "商品列表";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$query = "select count(*) from product";
$count_res = get_num($conn, $query);
//一页6个
$page_size = 6;
$page = page($count_res, $page_size, 5);
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title">商品列表</div>
    <table class="list">
        <tr>
            <th>商品名称</th>
            <th>商品ID</th>
            <th>商品价格</th>
            <th>图片url</th>
            <th>商品描述</th>
            <th>所属子目录</th>
            <th>操作</th>
        </tr>
        <?php
        $query = "select * from product {$page['limit']}";
        $result = execute($conn, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("product_delete.php?id={$data['productID']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "确定要删除商品 {$data['dirName']} 吗？";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";

            $tem_query = "select * from subDirInfo where id={$data['subDir_id']}";
            $tem_result = execute($conn, $tem_query);
            $tem_data = mysqli_fetch_assoc($tem_result);

            $html=<<<DD
        <tr>
            <th style="width: 160px"><a href="productAttribute.php?id={$data['productID']}" style="color: black; font-size: medium">{$data['productName']}</a></th>
            <th>{$data['productID']}</th>
            <th>{$data['productPrice']}</th>
            <th><a target="_blank" href="{$data['productImgURL']}">点击查看</a></th>
            <th style="width: 240px">{$data['description']}</th>
            <th>{$tem_data['subDirName']}</th>
            <th><a href="productAttribute.php?id={$data['productID']}">[查看]</a> <a href="product_update.php?id={$data['productID']}">[编辑]</a><a href={$delete_url}>[删除]</a></th>
        </tr>
DD;
            echo $html;
        }
        ?>
    </table>

    <div class="pages_wrap_show">
        <div class="pages">
            <?php
            echo $page['html'];
            ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.inc.php'?>



