<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$template['title'] = '更新子目录';
$template['css'] = array('css/index.css');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('subDirInfo.php', 'error', 'id参数错误！');
}
$query = "select * from subDirInfo where id={$_GET['id']}";
$result = execute($conn, $query);
if (!mysqli_num_rows($result)) {
    skip('subDirInfo.php', 'error', '该子目录不存在！');
}
if (isset($_POST['submit'])) {
    $check_type = 'update';
    include 'inc/subDirInfo_check.inc.php';

    $query = "update subDirInfo set subDirName='{$_POST['subDirName']}', dir_id={$_POST['dir_id']}, info='{$_POST['info']}', sort={$_POST['sort']} where id={$_GET['id']}";
//    echo $query;
//    exit();
    $result = execute($conn, $query);
    if (mysqli_affected_rows($conn) == 1) {
        skip('subDirInfo.php', 'ok', '修改成功！');
    }
    else {
        skip("subDirInfo_update.php?id={$_GET['id']}", 'error', '修改失败，请重试！');
    }
}

$data = mysqli_fetch_assoc($result);
?>

<?php include './inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">修改子目录 : <?php echo $data['subDirName']?></div>
    <form method="post">
        <table class="au">
            <tr>
                <td>所属目录</td>
<!--                    --><?php //print_r($data); ?>
                <td>
                    <select name="dir_id">
                        <option value="0">------请选择一个目录------</option>
                        <?php
                        $query = "select * from dirInfo";
                        $result = execute($conn, $query);

                        while ($data_tem = mysqli_fetch_assoc($result)) {
                            $tem = $data['dir_id'] == $data_tem['id'];
                            echo "<option value='{$data_tem['id']}'" . ($tem ? " selected='selected'" : "") . ">{$data_tem['dirName']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="note">
                    必须选择一个所属的目录
                </td>
            </tr>

            <tr>
                <td>子目录名称</td>
                <td><input name="subDirName" type="text" value="<?php echo $data['subDirName']; ?>"/></td>
                <td class="note">
                    版块名称不得为空，且最长不得超过50个字符
                </td>
            </tr>

            <tr>
                <td>子目录简介</td>
                <td>
                    <textarea name="info"><?php echo $data['info']; ?></textarea>
                </td>
                <td class="note">
                    版块名称不得为空，且最长不得超过50个字符
                </td>
            </tr>

            <tr>
                <td>排序优先级</td>
                <td><input name="sort" type="text" value="<?php echo $data['sort']; ?>" /></td>
                <td class="note">
                    填写一个数字即可，越大则优先级越高
                </td>
            </tr>
        </table>
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>
