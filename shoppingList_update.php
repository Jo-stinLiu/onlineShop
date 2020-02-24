<?php

include_once "inc/mysql.inc.php";
include_once "inc/config.inc.php";
include_once "inc/tool.inc.php";

$conn = connect();
$member_id = is_login($conn);

if(!isset($_POST['num']) || !is_numeric($_POST['num']) || !isset($_POST['id'])){
    skip('shoppingList.php','error','参数错误，修改失败！');
}

$_SESSION[$member_id]['list'][$_POST['id']]['num'] = $_POST['num'];
if ($_SESSION[$member_id]['list'][$_POST['id']]['num'] == $_POST['num']) {
    skip('shoppingList.php','ok','修改成功！', 1);
}
else {
    skip('shoppingList.php','error','修改失败，请重试！');
}

?>
