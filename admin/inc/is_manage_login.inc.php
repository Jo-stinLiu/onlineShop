<?php

if(!is_manage_login($conn)){
    header('Location:login.php');
    exit();
}
if(basename($_SERVER['SCRIPT_NAME'])=='manage_delete.php' || basename($_SERVER['SCRIPT_NAME'])=='manage_add.php'){
    if($_SESSION['manage']['level'] != '0'){
        if(!isset($_SERVER['HTTP_REFERER'])) {
            $_SERVER['HTTP_REFERER'] = 'index.php';
        }
        skip('index.php','error','权限不足！');
    }
}
?>