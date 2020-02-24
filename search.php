<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';

$template['title'] = '搜索页';
$template['css'] = array('css/public.css','css/index.css');

$conn = connect();
$member_id = is_login($conn);
$is_manage_login = is_manage_login($conn);

if(!isset($_GET['keyword'])) {
    $_GET['keyword'] = '';
}

$_GET['keyword'] = trim($_GET['keyword']);
$_GET['keyword'] = escape($conn, $_GET['keyword']);

$query = "select count(*) from product where productName like '%{$_GET['keyword']}%'";
$count_all = get_num($conn, $query);
$page = page($count_all, 5, 5);

include 'inc/header.inc.php'
?>
    <div id="main">
        <div class="title" align="center" style="margin-bottom: 15px; background-color: #a6e1ec; color: black">搜索结果</div>
        <div>
            <table class="list">
                <?php
                $query = "select * from product where productName like '%{$_GET['keyword']}%' {$page['limit']}";
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


<?php include 'inc/footer.inc.php'?>