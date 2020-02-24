<?php

date_default_timezone_set('Asia/Shanghai');
session_start();
header('Content-type:text/html;charset=utf-8');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASSWORD', 'miracle');
define('DB_DATABASE', 'onlineShop');
define('SA_PATH',dirname(dirname(__FILE__)));
define('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',SA_PATH)).'/');
?>
