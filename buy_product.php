<?php

include_once "inc/mysql.inc.php";
include_once "inc/config.inc.php";
include_once "inc/tool.inc.php";
include_once "inc/page.inc.php";

$template['title'] = '产品购买页';
$template['css'] = array('css/public.css', 'css/index.css');
$conn = connect();
$member_id = is_login($conn);

$query = "select count(*) from productAttribute where productID={$_GET['id']}";
$count_res = get_num($conn, $query);
//一页6个
$page_size = 6;
$page = page($count_res, $page_size, 5);

$query = "select * from product where productID={$_GET['id']}";
$result = execute($conn, $query);
$pro_data = mysqli_fetch_assoc($result);
$img = explode("../", "{$pro_data['productImgURL']}")[1];
include 'inc/header.inc.php';
?>
<div id="main">
    <div class="title" align="center" style="margin-bottom: 15px; background-color: #5bc0de; color: snow"><?php echo $pro_data['productName'] ?></div>
    <div>
        <div style="text-align: center; margin: 0 auto"><img src="<?php echo $img;?>" width="500px"></div>
        <table class="list" style="margin-left: 18%">
            <tr>
                <th style="width: 12%">uniqueID</th>
                <th>颜色</th>
                <th>尺寸</th>
                <th>具体价格</th>
                <th>数量</th>
            </tr>
            <?php
            $query = "select * from productAttribute where productID={$_GET['id']} {$page['limit']}";
            $result = execute($conn, $query);
            while ($data = mysqli_fetch_assoc($result)) {
                $html= <<<DD
            <tr>
                <td style="font-size: medium;text-align: center; margin-right: 0">{$data['uniqueID']}</td>
                <td style="font-size: medium;text-align: center; margin-right: 0">{$data['productColor']}</td>
                <td style="font-size: medium;text-align: center; margin-right: 0">{$data['productSize']}</td>
                <td style="font-size: medium;text-align: center; margin-right: 0">{$data['productPrice']}</td>
                <td style="font-size: medium;text-align: center; margin-right: 0">
                    <form action="shoppingList_add.php" method="post">
                        <input name="num" type="text" style="margin-right: 20px; width: 100px; height: 26px; padding-bottom: 2px">
                        <input name="uniqueID" style="display: none" value="{$data['uniqueID']}">
                        <button class="btn btn-default" type="submit">选择</button>
                    </form>
                </td>
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


</div>
