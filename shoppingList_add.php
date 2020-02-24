<?php

include_once "inc/mysql.inc.php";
include_once "inc/config.inc.php";
include_once "inc/tool.inc.php";
include_once "inc/page.inc.php";

$conn = connect();
$member_id = is_login($conn);

if (!$member_id) {
    skip('login.php', 'error', '请先登录!');
}

if (isset($_POST['num']) && isset($_POST['uniqueID'])) {
    if (!is_array($_SESSION[$member_id]['list'])) {
        $_SESSION[$member_id]['list'] = array();
    }
    $cnt = count($_SESSION[$member_id]['list']);
    $_SESSION[$member_id]['list']["{$_POST['uniqueID']}"] = array('num' => $_POST['num'], 'uniqueID' => $_POST['uniqueID']);
//    print_r($_SESSION['list']);
    if (count($_SESSION[$member_id]['list']) == $cnt + 1) {
        skip("shoppingList.php", 'ok', "加入购物车成功");
    }
    else {
        skip("index.php", 'error', "加入购物车失败");
    }
}
else {
    skip("index.php", 'error', "加入购物车失败");
}