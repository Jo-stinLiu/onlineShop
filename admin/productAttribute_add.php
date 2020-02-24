<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "添加商品属性";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (isset($_POST['submit'])) {
    //验证
    $check_type = 'add';
    include_once 'productAttribute_check.inc.php';
    $query = "insert into productAttribute(productID, uniqueID, productColor, productSize, productPrice) values('{$_GET['id']}', '{$_GET['id']}-{$_POST['uniqueID']}', '{$_POST['productColor']}', '{$_POST['productSize']}', {$_POST['productPrice']})";
//    echo $query;
//    exit();
    execute($conn, $query);

    if (mysqli_affected_rows($conn) == 1) {
        skip("productAttribute.php?id={$_GET['id']}", 'ok', '商品属性添加成功！');
    }
    else {
        skip("productAttribute_add.php?id={$_GET['id']}", 'error', '商品属性添加失败，请重试！');
    }
}

$query = "select * from product where productID={$_GET['id']}";
$pro_res = execute($conn, $query);
$pro_data = mysqli_fetch_assoc($pro_res);
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">为商品 <?php echo $pro_data['productName'], ' [productID : ', $pro_data['productID'], '] ' ?> 添加商品属性</div>
    <form method="post">
        <table class="au">
            <tr>
                <td style="width: 80px">uniqueID后缀</td>
                <td><input name="uniqueID" type="text" /></td>
                <td class="note">后缀不能为空，将用productID作为前缀，一起构成uniqueID，总的字符数不超过255，uniqueID不能与已有的重复</td>
            </tr>
            <tr>
                <td>颜色</td>
                <td><input name="productColor" type="text" /></td>
                <td class="note">商品颜色</td>
            </tr>
            <tr>
                <td>尺寸</td>
                <td><input name="productSize" type="text" /></td>
                <td class="note">商品尺寸</td>
            </tr>
            <tr>
                <td>具体价格</td>
                <td><input name="productPrice" type="text" /></td>
                <td class="note">该颜色和该尺寸对应的价格</td>
            </tr>
        </table>
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>
