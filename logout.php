<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$conn = connect();
$member_id = is_login($conn);
if (!$member_id) {
    skip('index.php', 'error', '你未登录，无需退出！');
}
//if (isset($_SESSION['list'])) {
//    unset($_SESSION['list']);
//}
setcookie('username', '', time() - 3600);
skip('index.php', 'ok', '退出成功！');
?>