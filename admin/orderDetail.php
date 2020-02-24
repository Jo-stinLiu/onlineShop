<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.inc.php';

$template['title'] = '交易记录';
$template['css'] = array('css/public.css', 'css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$type = 1;
$page = 0;
if (isset($_GET['type']) && $_GET['type'] == 2) {
    $type = 2;
}

?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title">交易记录</div>
    <div style="margin: 20px auto; text-align: center">
        <?php
        if ($type == 1) {
            $html=<<<DD
        <a><button type="button" class="btn btn-default focus" style="margin-right: 30px">用户交易</button></a>
        <a href="orderDetail.php?type=2"><button type="button" class="btn btn-default">厂家交易</button></a>
    </div>
DD;
        }
        else {
            $html=<<<DD
        <a href="orderDetail.php?type=1"><button type="button" class="btn btn-default" style="margin-right: 30px">用户交易</button></a>
        <a><button type="button" class="btn btn-default focus">厂家交易</button></a>
    </div>
DD;
        }
        echo $html;

        if ($type == 1) {
            $html=<<<DD
        <table class="list">
        <tr>    
            <th>订单号</th>
            <th>用户</th>
            <th>uniqueID</th>
            <th>购买时间</th>
            <th>数量</th>
            <th>总价</th>
        </tr>
DD;
            echo $html;

            $query = "select count(*) from shoppingOrder";
            $count_res = get_num($conn, $query);
            $page = page($count_res, 6, 5);

            $query = "select * from shoppingOrder {$page['limit']}";
            $result = execute($conn, $query);
            while ($data = mysqli_fetch_assoc($result)) {
                $pro_id = explode('-', "{$data['uniqueID']}")[0];

                $html = <<<DD
        <tr>
            <td>{$data['ShoppingOrderID']}</td>
            <td><a target="_blank" href="../member.php?id={$data['customerID']}">{$data['customerID']}</a></td>
            <td><a href="productAttribute.php?id={$pro_id}">{$data['uniqueID']}</a></td>
            <td>{$data['orderTime']}</td>
            <td>{$data['num']}</td>
            <td>{$data['totalPrice']}</td>
        </tr>
DD;
                echo $html;
            }
        }
        else {
            $html=<<<DD
        <table class="list">
        
        <tr>
            <th>订单号</th>
            <th>uniqueID</th>
            <th>订单时间</th>
            <th>仓库名</th>
            <th>数量</th>
            <th>进货价</th>
            <th>总价</th>
        </tr>
DD;
            echo $html;

            $query = "select count(*) from ManufacturerOrder";
            $count_res = get_num($conn, $query);
            $page = page($count_res, 6, 5);

            $query = "select * from ManufacturerOrder {$page['limit']}";
            $result = execute($conn, $query);
            while ($data = mysqli_fetch_assoc($result)) {
                $pro_id = explode('-', "{$data['uniqueID']}")[0];
                $price = $data['num'] * $data['unitPrice'];

                $html = <<<DD
        <tr>
            <td>{$data['orderID']}</td>
            <td><a href="productAttribute.php?id={$pro_id}">{$data['uniqueID']}</a></td>
            <td>{$data['orderTime']}</td>
            <td><a href="warehouseDetail.php?id={$data['warehouseName']}">{$data['warehouseName']}</a></td>
            <td>{$data['num']}</td>
            <td>{$data['unitPrice']}</td>
            <td>{$price}</td>
        </tr>
DD;
                echo $html;
            }

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
