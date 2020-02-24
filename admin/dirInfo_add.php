<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = '添加目录';
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (isset($_POST['submit'])) {
    $check_type = 'add';
    include 'inc/dirInfo_check.inc.php';
    $query = "insert into dirInfo (dirName) values ('{$_POST['dirName']}')";
    execute($conn, $query);
    if (mysqli_affected_rows($conn) == 1) {
        skip('dirInfo.php', 'ok', '目录添加成功！');
    }
    else {
        skip('dirInfo_add.php', 'error', '目录添加失败，请重试！');
    }
}
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">添加目录</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>目录名称</td>
                <td><input name="dirName" type="text" /></td>
                <td class="note">
                    目录名称不得为空，且最长不得超过10个字符
                </td>
            </tr>
        </table>
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php include 'inc/footer.inc.php' ?>
