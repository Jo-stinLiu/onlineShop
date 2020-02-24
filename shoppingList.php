<?php

include_once "inc/mysql.inc.php";
include_once "inc/config.inc.php";
include_once "inc/tool.inc.php";
include_once "inc/page.inc.php";

$template['title'] = '购物车';
$template['css'] = array('css/public.css', 'css/index.css');
$conn = connect();
$member_id = is_login($conn);

$warehouse_default = "warehouse000";

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $res = execute_multi($conn, $query);
    if (!mysqli_error($conn)) {
        unset($_SESSION[$member_id]['list']);
        skip('index.php', 'ok', "您已购买成功");
    }
    else {
        skip('shoppingList.php', 'error', "购买失败！");
    }
}


include 'inc/header.inc.php';
?>

<div id="main">
    <div class="title" style="margin: 0 auto 15px auto; background-color: #46b8da; color: white"><span style="padding-left: 41%">购物车</span></div>
    <div>
        <?php
        $moneyCnt = 0;
        $numCnt = 0;
        $qy = "";
        $orderID = date('Y-m-d-').strval(rand(0, 99999));

        if (!isset($_SESSION[$member_id]['list']) || count($_SESSION[$member_id]['list']) == 0) {
            echo "<div align='center' style='color: lightgrey; margin-top: 30px; padding-left: 0px; font-size: large'>当前购物车为空</div>";
        }
        else {
            $html=<<<DD
        <table class="list" style="margin-left: 5%">
            <th>
                <th>描述</th>
                <th>价格</th>
                <th style="padding-right: 5px">数量</th>
                <th style="padding-right: 5px">操作</th>
            </tr>
DD;
            echo $html;

            foreach ($_SESSION[$member_id]['list'] as $key => $value) {
                $query = "select * from product where productID=(select productID from productAttribute where uniqueID='{$key}')";
                $result = execute($conn, $query);
                $pro_data = mysqli_fetch_assoc($result);

                $query = "select * from productAttribute where uniqueID='{$key}'";
                $result = execute($conn, $query);
                $data = mysqli_fetch_assoc($result);

                $img = explode("../", "{$pro_data['productImgURL']}")[1];
                $url = urlencode("shoppingList_delete.php?id={$key}");
                $return_url = urlencode($_SERVER['REQUEST_URI']);
                $message = "确定要删除商品 {$pro_data['productName']} 吗？";
                $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";

                $curCnt = $data['productPrice'] * $_SESSION[$member_id]['list'][$key]['num'];
                $moneyCnt += $curCnt;
                $numCnt += $_SESSION[$member_id]['list'][$key]['num'];

                $qy .= "insert into shoppingOrder (ShoppingOrderID, uniqueID, customerID, orderTime, num, totalPrice) values ('{$orderID}', '{$key}', '{$member_id}', now(), {$_SESSION[$member_id]['list'][$key]['num']}, {$curCnt});";
                $tem_query = "select count(*) from {$warehouse_default} where uniqueID='{$key}'";
                $get_num = get_num($conn, $tem_query);
                if ($get_num == 0) {
                    $qy .= "insert into {$warehouse_default} (uniqueID, num) values ('{$key}', 0);";
                }
                $qy .= "update {$warehouse_default} set num = num - {$_SESSION[$member_id]['list'][$key]['num']};";
//                print_r($qy);
                $html=<<<DD
            <tr>
                <td><img src="{$img}" style="width: 250px"></td>
                <td width="470px" style="margin-left: 15px">
                    <div>
                        <a href="buy_product.php?id={$pro_data['productID']}" style="font-size: large; color: black; font-weight: bolder">{$pro_data['productName']}</a> : {$pro_data['description']}
                    </div>
                    <div style="padding-top: 20px">
                        <span style="font-size: large; color: black; font-weight: normal">颜色：{$data['productColor']}&nbsp;&nbsp;&nbsp;&nbsp;尺寸：{$data['productSize']}</span>
                    </div>
                </td>
                <td style="font-size: medium">¥ {$pro_data['productPrice']}</td>
                <td>
                    <form action="shoppingList_update.php" method="post">
                        <input name="num" type="text" style="margin-right: 10px; width: 50px; height: 26px; padding-bottom: 2px" value="{$value['num']}">
                        <input name="id" style="display: none" value="{$key}">
                        <button class="btn btn-default" type="submit">修改数量</button>
                    </form>
                </td>
                <td style="padding-right: 5px"><a href="{$delete_url}"><button class="btn btn-default">删除</button></a></td>
            </tr>
DD;
                echo $html;
            }
            $qy .= "update member set cost = cost + {$moneyCnt} where username='{$member_id}'";
            echo "</table>";
        }
        ?>
    </div>
    <div style="text-align: center; margin: 20px auto">
        <span style="font-size: large; color: black">总共 <?php echo $moneyCnt; ?> 元</span><span style="margin-left: 20px;font-size: large; color: black">共 <?php echo $numCnt; ?> 件商品</span>
        <form method="post" action="" style="margin-top: 20px">
            <input style="display: none;" type="text" name="query" value="<?php echo $qy; ?>">
            <button class="btn btn-default">确认购买</button>
        </form>
    </div>
</div>

<?php
include 'inc/footer.inc.php';
?>
