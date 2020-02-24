<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "修改商品属性";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if(!isset($_GET['id'])){
    skip('product.php','error','id参数错误！');
}
$productID = explode('-', "{$_GET['id']}")[0];

$query = "select * from productAttribute where uniqueID='{$_GET['id']}'";
$result = execute($conn, $query);

if (isset($_POST['submit'])) {
    $check_type = 'update';
//    include_once 'productAttribute_check.inc.php';
    $query = "update productAttribute set uniqueID='{$productID}-{$_POST['uniqueID']}', productColor='{$_POST['productColor']}', productSize='{$_POST['productSize']}', productPrice={$_POST['productPrice']} where uniqueID='{$_GET['id']}'";
    execute($conn, $query);

    if (mysqli_affected_rows($conn) == 1) {
        skip("productAttribute.php?id={$productID}", 'ok', '修改成功！');
    }
    else {
        skip("productAttribute_update.php?id={$_GET['id']}", 'error', '修改失败，请重试！');
    }
}


$data = mysqli_fetch_assoc($result);

$query = "select * from product where productID={$productID}";
$result = execute($conn, $query);
$pro_data = mysqli_fetch_assoc($result);
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">修改商品 <?php echo $pro_data['productName'], ' [productID : ', $pro_data['productID'], '] ' ?> 的商品属性</div>
    <form method="post">
        <table class="au">
            <tr>
                <td style="width: 80px">uniqueID后缀</td>
                <td><input name="uniqueID" type="text" value="<?php echo explode('-', "{$_GET['id']}")[1]; ?>" /></td>
                <td class="note">后缀不能为空，将用productID作为前缀，一起构成uniqueID，总的字符数不超过255，uniqueID不能与已有的重复</td>
            </tr>
            <tr>
                <td>颜色</td>
                <td><input name="productColor" type="text" value="<?php echo $data['productColor']; ?>" /></td>
                <td class="note">商品颜色</td>
            </tr>
            <tr>
                <td>尺寸</td>
                <td><input name="productSize" type="text" value="<?php echo $data['productSize']; ?>" /></td>
                <td class="note">商品尺寸</td>
            </tr>
            <tr>
                <td>具体价格</td>
                <td><input name="productPrice" type="text" value="<?php echo $data['productPrice']; ?>" /></td>
                <td class="note">该颜色和该尺寸对应的价格</td>
            </tr>
        </table>
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>
