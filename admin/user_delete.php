<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';
?>
<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('user_list.php', 'error', 'id参数错误！');
}
$query = "delete from member where id={$_GET['id']}";
execute($conn, $query);
if (mysqli_affected_rows($conn) == 1) {
    skip('user_list.php', 'ok', '删除成功！');
}
else {
    skip('user_list.php', 'error', '删除失败，请重试！');
}
?>
