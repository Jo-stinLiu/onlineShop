<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "onlineShop后台管理";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';
?>

<?php include 'inc/header.inc.php'?>

<div id="main">
    <div class="title">仓库列表</div>
    <table class="list">
        <tr>
            <th>仓库名称</th>
            <th>仓库位置</th>
            <th>仓库负责人</th>
            <th>操作</th>
        </tr>

        <?php
        $query = "select * from warehouseInfo join employee on principal=id";
//        echo $query;
//        exit();
        $result = execute($conn, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("warehouse_delete.php?id={$data['warehouseID']}&warehouseName={$data['warehouseName']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "确定要删除仓库 {$data['warehouseName']} 吗？";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
//            echo $delete_url;
            $html=<<<DD
        <tr>
            <td>{$data['warehouseName']}&nbsp;[id:&nbsp;{$data['warehouseID']}]</td>
            <td>{$data['warehouseLocation']}</td>
            <td>{$data['lastName']}{$data['firstName']} [id:{$data['principal']}]</td>
            <td><a href="warehouseDetail.php?id={$data['warehouseName']}">[详细]</a>  <a href="warehouse_update.php?id={$data['warehouseID']}&warehouseName={$data['warehouseName']}">[编辑]</a>  <a href=$delete_url>[删除]</a></td>
        </tr>
DD;
            echo $html;
        }
        ?>
    </table>
</div>
<?php include 'inc/footer.inc.php'?>

