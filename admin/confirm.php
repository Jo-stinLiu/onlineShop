<?php

include_once '../inc/config.inc.php';
if (!isset($_GET['url']) || !isset($_GET['message']) || !isset($_GET['return_url'])) {
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>
        <title>确认操作</title>
        <link rel="shortcut icon" href="css/bbs32.png">
        <link rel="stylesheet" href="css/warn.css">
    </head>
    <body>
        <div class="warn"><span class="pic ask"></span>&nbsp;&nbsp;<?php echo $_GET['message'] ?>&nbsp;<a href="<?php echo $_GET['url'] ?>" style="color:red;">确认</a> |
            <a href="<?php echo $_GET['return_url']?>" style="color:#666;">取消</a></div>
    </body>
</html>