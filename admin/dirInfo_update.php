<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "更新目录信息";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('dirInfo.php', 'error', 'id参数错误');
}
$query = "select * from dirInfo where id={$_GET['id']}";
$result = execute($conn, $query);

if (!mysqli_num_rows($result)) {
    skip('dirInfo.php', 'error', '该目录不存在！');
}

if (isset($_POST['submit'])) {
    $check_type = 'update';
    include 'inc/dirInfo_check.inc.php';

    $query = "update dirInfo set dirName='{$_POST['dirName']}',sort={$_POST['sort']} where id={$_GET['id']}";
//    echo $query;
//    exit();
    $result = execute($conn, $query);
    if (mysqli_affected_rows($conn) == 1) {
        skip('dirInfo.php', 'ok', '修改成功！');
    }
    else {
        skip("dirInfo_update.php?id={$_GET['id']}", 'error', '修改失败，请重试');
    }

}
$data = mysqli_fetch_assoc($result);
?>
<?php include 'inc/header.inc.php'?>
    <div id="main">
        <div class="title">修改目录 : <?php echo $data['dirName']?></div>

        <form method="post">
            <table class="au">
                <tr>
                    <td>目录名称</td>
                    <td><input name="dirName" value="<?php echo $data['dirName']?>" type="text"/></td>
                    <td class="note">目录名称不得为空，且最长不得超过10个字符</td>
                </tr>
                <tr>
                    <td>排序优先级</td>
                    <td><input name="sort" value="<?php echo $data['sort']?>" type="text" /></td>
                    <td class="note">
                        填写一个数字，越大则显示在越前面
                    </td>
                </tr>
            </table>
            <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
        </form>
    </div>
<?php include './inc/footer.inc.php'?>