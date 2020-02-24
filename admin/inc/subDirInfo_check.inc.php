<?php
    switch ($check_type) {
        case 'add':
            //这里先限定所有的子版块不能重名，后续再改进为同一个父版块下的子版块不能重名
            if (!is_numeric($_POST['dir_id'])) {
                skip('subDirInfo_add.php', 'error', '所选的目录不合法！');
            }
            if (empty($_POST['subDirName'])) {
                skip('subDirInfo_add.php', 'error', '子目录名称不能为空');
            }
            if (mb_strlen($_POST['subDirName']) > 50) {
                skip('subDirInfo_add.php', 'error', '子目录名称最长为50个字符！');
            }
            if (mb_strlen($_POST['info']) > 255) {
                skip('subDirInfo_add.php', 'error', '子目录简介最长为255个字符！');
            }
//            if (!is_numeric($_POST['sort'])) {
//                skip('subDirInfo_add.php', 'error', '请用数字来表示排序优先级！');
//            }
            $query = "select * from dirInfo where id={$_POST['dir_id']}";
            $result = execute($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                skip('subDirInfo_add.php', 'error', '所选的目录不存在！');
            }
            $_POST = escape($conn, $_POST);

            $query = "select * from subDirInfo where subDirName='{$_POST['subDirName']}'";
            $result = execute($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                skip('subDirInfo_add.php', 'error', '该子版块已存在！');
            }
            break;

        case 'update':
            if (!is_numeric($_POST['dir_id'])) {
                skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '所选的目录不合法！');
            }
            if (empty($_POST['subDirName'])) {
                skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '子目录名称不能为空');
            }
            if (mb_strlen($_POST['subDirName']) > 50) {
                skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '子目录名称最长为50个字符！');
            }
            if (mb_strlen($_POST['info']) > 255) {
                skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '子目录简介最长为255个字符！');
            }
            if (!is_numeric($_POST['sort'])) {
                skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '请用数字来表示排序优先级！');
            }
            $query = "select * from dirInfo where id={$_POST['dir_id']}";
            $result = execute($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '所选的目录不存在！');
            }
            $_POST = escape($conn, $_POST);

            $query = "select * from subDirInfo where subDirName='{$_POST['subDirName']}' and id!={$_GET['id']}";
            $result = execute($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '该子版块已存在！');
            }
            break;

        default:
            skip('subDirInfo.php', 'error', '内部参数发生错误！请联系上层管理员！');
    }
?>