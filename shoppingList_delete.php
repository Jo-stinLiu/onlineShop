<?php

include_once "inc/mysql.inc.php";
include_once "inc/config.inc.php";
include_once "inc/tool.inc.php";

$conn = connect();
$member_id = is_login($conn);

if(!isset($_GET['id'])){
    skip('shoppingList.php','error','id参数错误！请联系管理员');
}

$cnt = sizeof($_SESSION[$member_id]['list']);
unset($_SESSION[$member_id]['list'][$_GET['id']]);
if (sizeof($_SESSION[$member_id]['list']) == $cnt - 1) {
    skip('shoppingList.php','ok','删除成功！');
}
else {
    skip('shoppingList.php','error','删除失败，请重试！');
}

?>
