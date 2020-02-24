<?php

include_once "inc/mysql.inc.php";
include_once "inc/config.inc.php";
include_once "inc/tool.inc.php";
include_once "inc/page.inc.php";

$template['title'] = '首页';
$template['css'] = array('css/public.css', 'css/index.css');
$conn = connect();
$member_id = is_login($conn);

$query = "select count(*) from product";
$count_res = get_num($conn, $query);
//一页6个
$page_size = 6;
$page = page($count_res, $page_size, 5);
include 'inc/header.inc.php';
?>

<div id="main">
    <div class="title" align="center" style="margin-bottom: 15px">夏季新品</div>
    <div>
        <table class="list">
            <?php
            $query = "select * from product {$page['limit']}";
            $result = execute($conn, $query);
            while ($data = mysqli_fetch_assoc($result)) {
                $img = explode("../", "{$data['productImgURL']}")[1];
                $html=<<<DD
            <tr>
                <td><img src="{$img}" style="width: 250px"></td>
                <td width="550px" style="margin-left: 15px"><a href="buy_product.php?id={$data['productID']}" style="font-size: large; color: black; font-weight: bolder">{$data['productName']}</a> : {$data['description']}</td>
                <td style="font-size: medium">¥ {$data['productPrice']}</td>
                <td><a href="buy_product.php?id={$data['productID']}"><button class="btn btn-default">选择</button></a></td>
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

<?php
include 'inc/footer.inc.php';
?>