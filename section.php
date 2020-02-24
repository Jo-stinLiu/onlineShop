<?php

include_once "inc/mysql.inc.php";
include_once "inc/config.inc.php";
include_once "inc/tool.inc.php";
include_once "inc/page.inc.php";

$template['title'] = '分区';
$template['css'] = array('css/public.css', 'css/index.css');
$conn = connect();
$member_id = is_login($conn);

if (!isset($_GET['name'])) {
    skip('index.php', 'error', "不存在该页面");
}
include 'inc/header.inc.php';
?>
<div id="main">
    <?php
    $query = "select * from subDirInfo where dir_id=(select id from dirInfo where dirName='{$_GET['name']}') order by sort desc";
    $subdir_res = execute($conn, $query);
    while ($subdir_data = mysqli_fetch_assoc($subdir_res)) {
        $html=<<<DD
    <div id="section"><div class="section_title">{$subdir_data['subDirName']}</div></div>
    <table class="list">
DD;
        echo $html;
        $query = "select * from product where subDir_id={$subdir_data['id']}";
        $res = execute($conn, $query);
        while ($data = mysqli_fetch_assoc($res)) {
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
        echo "</table>";
    }
    ?>
</div>
<?php
include 'inc/footer.inc.php';
?>

