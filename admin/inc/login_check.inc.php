<?php

if(empty($_POST['name'])){
    skip('login.php','error','管理员名称不得为空！');
}
if(mb_strlen($_POST['name']) > 30) {
    skip('login.php','error','管理员名称不得多余30个字符！');
}
if(mb_strlen($_POST['pw']) < 6) {
    skip('login.php','error','密码不得少于6位！');
}

?>
