<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$ID = isset($_POST['user_name']) ? $_POST['user_name'] : "";

if ($ID == "") {
    exit(json_encode(array("flag"=>false, "msg"=>"查询参数错误！")));
}
else {
    $conn = connect();
    $query = "select * from member where ID='{$ID}'";
    $cnt = get_num($conn, $query);
    if ($cnt == 0) {
        exit(json_encode(array("flag"=>true, "msg"=>0)));       //可使用
    } else {
        exit(json_encode(array("flag"=>true, "msg"=>1)));       //有重复
    }
}
?>