<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$template['title'] = '添加子目录';
$template['css'] = array('css/index.css');

if (isset($_POST['submit'])) {
    //验证
    $check_type = 'add';
    include 'inc/subDirInfo_check.inc.php';
    //默认最低优先级
    $_POST['sort'] = 0;
    $query = "insert into subDirInfo(subDirName, dir_id, info, sort) values('{$_POST['subDirName']}', {$_POST['dir_id']}, '{$_POST['info']}', {$_POST['sort']})";
//    echo $query;
//    exit();
    execute($conn, $query);

    if (mysqli_affected_rows($conn) == 1) {
        skip('subDirInfo.php', 'ok', '子目录添加成功！');
    }
    else {
        skip('subDirInfo_add.php', 'error', '子目录添加失败，请重试！');
    }
}
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">添加子目录</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>子目录名称</td>
                <td><input name="subDirName" type="text" /></td>
                <td class="note">
                    子目录名称不得为空，且最长不得超过50个字符
                </td>
            </tr>

            <tr>
                <td>所属目录</td>
                <td>
                    <select name="dir_id">
                        <option value="0">------请选择一个目录------</option>
                        <?php
                            $query = "select * from dirInfo";
                            $result = execute($conn, $query);

                            while ($data = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$data['id']}'>{$data['dirName']}</option>";
                            }
                        ?>
                    </select>
                </td>
                <td class="note">
                    必须选择一个所属的目录
                </td>
            </tr>

            <tr>
                <td>子目录简介</td>
                <td>
                    <textarea name="info"></textarea>
                </td>
                <td class="note">
                    建议添加子目录简介，优化用户体验
                </td>
            </tr>

<!--            <tr>-->
<!--                <td>排序优先级</td>-->
<!--                <td><input name="sort" type="text" /></td>-->
<!--                <td class="note">-->
<!--                    填写一个数字即可，越大则优先级越高-->
<!--                </td>-->
<!--            </tr>-->
        </table>
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php include 'inc/footer.inc.php' ?>