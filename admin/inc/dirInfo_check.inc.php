<?php
    switch ($check_type) {
        case 'add':
            if (empty($_POST['dirName'])) {
                skip('dirInfo_add.php', 'error', '目录名称不能为空！');
            }
            if (mb_strlen($_POST['dirName']) > 10) {
                skip('dirInfo_add.php', 'error', '目录名称最长为10个字符！');
            }
//            if (!is_numeric($_POST['sort'])) {
//                skip('dirInfo_add.php', 'error', '请用数字来表示排序优先级！');
//            }
            $_POST=escape($conn, $_POST);
            $query = "select * from dirInfo where dirName='{$_POST['dirName']}'";
            $result = execute($conn, $query);
            if (mysqli_num_rows($result)) {
                skip('dirInfo_add.php', 'error', '该目录已存在！');
            }
            break;

        case 'update':
            if (empty($_POST['dirName'])) {
                skip("dirInfo_update.php?id={$_GET['id']}", 'error', '目录名称不能为空！');
            }
            if (mb_strlen($_POST['dirName']) > 10) {
                skip("dirInfo_update.php?id={$_GET['id']}", 'error', '目录名称最长为10个字符！');
            }
            if (!is_numeric($_POST['sort'])) {
                skip("dirInfo_update.php?id={$_GET['id']}", 'error', '请用数字来表示排序优先级！');
            }
            $_POST=escape($conn, $_POST);
            $query = "select * from dirInfo where dirName='{$_POST['dirName']}' and id!={$_GET['id']}";
            $result = execute($conn, $query);
            if (mysqli_num_rows($result)) {
                skip('dirInfo_add.php', 'error', '该目录已存在！');
            }
            break;

        default:
            skip('dirInfo_add.php', 'error', '内部参数发生错误！请联系上层管理员！');
    }
?>