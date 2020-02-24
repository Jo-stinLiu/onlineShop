<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if(!isset($_GET['id'])){
    skip('product.php','error','id参数错误！');
}

$productID = explode('-', "{$_GET['id']}")[0];
//echo $productID;
//exit();
$query = "delete from productAttribute where uniqueID='{$_GET['id']}'";
execute($conn,$query);
if(mysqli_affected_rows($conn) == 1) {
    skip("productAttribute.php?id={$productID}",'ok','删除成功！');
}
else {
    skip("productAttribute.php?id={$productID}",'error','删除失败，请重试！');
}
?>

