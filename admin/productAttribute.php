<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.inc.php';

$template['title'] = "商品属性列表";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('product.php', 'error', 'id参数错误！');
}

$query = "select count(*) from productAttribute where productID={$_GET['id']}";
$count_res = get_num($conn, $query);
//一页6个
$page_size = 6;
$page = page($count_res, $page_size, 5);

$query = "select * from product where productID={$_GET['id']}";
$pro_res = execute($conn, $query);
$pro_data = mysqli_fetch_assoc($pro_res);
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title">商品 <?php echo $pro_data['productName'] ?> 属性列表</div>

    <?php
    $query = "select * from product where productID={$_GET['id']}";
    $pro_res = execute($conn, $query);
    $pro_data = mysqli_fetch_assoc($pro_res);
    $html = <<<DD
    <div style="text-align: center; margin: 15px 10%; font-size: medium; font-weight: bold">
        <span>{$pro_data['description']}</span>
    </div>
DD;
    echo $html;
    ?>

    <div style="margin-top: 20px">
        <a href="productAttribute_add.php?id=<?php echo $_GET['id'] ?>"><button type="button" class="btn btn-default">添加属性</button></a>
    </div>


    <table class="list">
        <tr>
            <th>uniqueID</th>
            <th>颜色</th>
            <th>尺寸</th>
            <th>具体价格</th>
            <th>操作</th>
        </tr>
        <?php
        $query = "select * from productAttribute where productID={$_GET['id']} {$page['limit']}";
        $result = execute($conn, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("productAttribute_delete.php?id={$data['uniqueID']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "确定要删除商品属性 {$data['uniqueID']} 吗？";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";

            $html=<<<DD
        <tr>
            <td>{$data['uniqueID']}</td>
            <td>{$data['productColor']}</td>
            <td>{$data['productSize']}</td>
            <td>{$data['productPrice']}</td>
            <td><a href="resource_add.php?id={$data['uniqueID']}">[添加库存]</a> <a href="productAttribute_update.php?id={$data['uniqueID']}">[编辑]</a> <a href="{$delete_url}">[删除]</a></td>
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
