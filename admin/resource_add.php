<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.inc.php';

$template['title'] = "选择具体商品";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (isset($_POST['submit'])) {
    $orderID = date('Y-m-d-').strval(rand(0, 99999));
    $query = "";

    $tem_query = "select count(*) from {$_POST['warehouseName']} where uniqueID='{$_GET['id']}'";
    $get_num = get_num($conn, $tem_query);

    if ($get_num == 0) {
        $query .= "insert into {$_POST['warehouseName']} (uniqueID, num) values ('{$_GET['id']}', {$_POST['num']});";
    }
    else {
        $query .= "update {$_POST['warehouseName']} set num = num + {$_POST['num']} where uniqueID='{$_GET['id']}';";
    }
    $query .= "insert into ManufacturerOrder (orderID, uniqueID, orderTime, warehouseName, num, unitPrice) values ('{$orderID}', '{$_GET['id']}', now(), '{$_POST['warehouseName']}', {$_POST['num']}, {$_POST['price']});";
    $query .= "update ManufacturerOrder set totalPrice = num * unitPrice where orderID='{$orderID}';";
    $sss = $query;

    execute_multi($conn, $query);
    if (!mysqli_error($conn, $query)) {
        skip("warehouseDetail.php?id={$_POST['warehouseName']}", 'ok', '添加库存成功');
    }
    else {
        skip("resource_add.php?id={$_GET['id']}", 'error', '添加失败');
    }
}

?>
<?php include 'inc/header.inc.php'?>

<div id="main">
<?php

if (!isset($_GET['id'])) {
    $query = "select count(*) from productAttribute";
    $count_all = get_num($conn, $query);
    $page = page($count_all, 6, 5);

    $query = "select * from productAttribute join product on product.productID = productAttribute.productID {$page['limit']}";
    $result = execute($conn, $query);

    $html=<<<DD
    <div class="title">选择具体商品</div>
    <table class="list">
        <tr>
            <th>商品名称</th>
            <th>uniqueID</th>
            <td>颜色</td>
            <td>尺寸</td>
            <th>商品价格</th>
            <th>操作</th>
        </tr>
DD;
    echo $html;

    while ($data = mysqli_fetch_assoc($result)) {

        $html=<<<DD
        <tr>
            <td><a href="productAttribute.php?id={$data['productID']}" style="font-size: large; color: black; font-weight: bolder">{$data['productName']}</a></td>
            <td>{$data['uniqueID']}</td>
            <td>{$data['productColor']}</td>
            <td>{$data['productSize']}</td>
            <td>{$data['productPrice']}</td>
            <td><a href="resource_add.php?id={$data['uniqueID']}"><input type="submit" name="submit" class="btn btn-default" value="选择"></a></td>
        </tr>
DD;
        echo $html;
    }

    $html=<<<DD
    </table>
    <div class="pages_wrap_show">
        <div class="pages">
            {$page['html']}
        </div>
    </div>
DD;
    echo $html;

}
else {
    $query = "select * from productAttribute natural join product where uniqueID='{$_GET['id']}'";
    $result = execute($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $html=<<<DD
    <div class="title">选择仓库和数量</div>
    
    <form method="post">
        <table class="au">
            <tr>
                <td>商品名称</td>
                <td style="color: black; font-weight: bold">{$data['productName']}</td>
            </tr>

            <tr>
                <td>uniqueID</td>
                <td style="color: black; font-weight: bold">{$data['uniqueID']}</td>
            </tr>
            
            <tr>
                <td>颜色</td>
                <td style="color: black; font-weight: bold">{$data['productColor']}</td>
            </tr>
            
            <tr>
                <td>尺寸</td>
                <td style="color: black; font-weight: bold">{$data['productSize']}</td>
            </tr>
            
            <tr>
                <td>价格</td>
                <td style="color: black; font-weight: bold">{$data['productPrice']}</td>
            </tr>

            <tr>
                <td>选择数量</td>
                <td><input name="num" type="text"><input style="display: none;" name="price" value="{$data['productPrice']}" ></td>
            </tr>
            
            <tr>
                <td>选择仓库</td>
                <td>
                    <select name="warehouseName">
                        <option value="0">-----请选择一个仓库-----</option>
DD;
    echo $html;
    $query = "select * from warehouseInfo";
    $ware_res = execute($conn, $query);
    while ($ware_data = mysqli_fetch_assoc($ware_res)) {
        $html=<<<DD
                        <option value="{$ware_data['warehouseName']}">[{$ware_data['warehouseLocation']}] {$ware_data['warehouseName']}</option>
DD;
        echo $html;
    }

    $html=<<<DD
                    </select>
                </td>
            </tr>
        </table>
        
        <input type="submit" name="submit" class="btn btn-default" value="确定" style="margin-left: 17%; margin-top: 25px" />
    </form>
DD;
    echo $html;
}


?>

</div>

<?php include 'inc/footer.inc.php'?>


