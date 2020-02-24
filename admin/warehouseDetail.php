<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.inc.php';

$template['title'] = "库存信息";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (!isset($_GET['id'])) {
    skip('warehouse.php', 'error', '参数错误！');
}

$query = "select count(*) from {$_GET['id']}";
$count_res = get_num($conn, $query);
//一页6个
$page_size = 6;
$page = page($count_res, $page_size, 5);

?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title">仓库 <?php echo $_GET['id'] ?> 库存列表</div>
    <table class="list">
        <tr>
            <th>uniqueID</th>
            <th>商品名称</th>
            <th>颜色</th>
            <th>尺寸</th>
            <th>数量</th>
        </tr>
        <?php
        $query = "select * from {$_GET['id']} {$page['limit']}";
        $result = execute($conn, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $pro_id = explode('-', "{$data['uniqueID']}")[0];

            $qy = "select * from product natural join productAttribute where uniqueID='{$data['uniqueID']}'";
            $pro_res = execute($conn, $qy);
            $pro_data = mysqli_fetch_assoc($pro_res);

            $html=<<<DD
        <tr>
            <td><a href="productAttribute.php?id={$pro_id}">{$data['uniqueID']}</a></td>
            <td>{$pro_data['productName']}</td>
            <td>{$pro_data['productColor']}</td>
            <td>{$pro_data['productSize']}</td>
            <td>{$data['num']}</td>
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
