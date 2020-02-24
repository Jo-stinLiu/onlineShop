<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "更新员工信息";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('employee.php', 'error', 'id参数错误');
}
$query = "select * from employee where id={$_GET['id']}";
$result = execute($conn, $query);

if (!mysqli_num_rows($result)) {
    skip('employee.php', 'error', '该员工不存在！');
}

if (isset($_POST['submit'])) {
    $check_type = 'update';
//    include 'inc/employee_check.inc.php';

    $query = "update employee set firstName='{$_POST['firstName']}', lastName='{$_POST['lastName']}', gender='{$_POST['gender']}', phone='{$_POST['phone']}', mail='{$_POST['mail']}', city='{$_POST['city']}', address='{$_POST['address']}', employee_position='{$_POST['employee_position']}' where id={$_GET['id']}";
//    echo $query;
//    exit();
    $result = execute($conn, $query);
    if (mysqli_affected_rows($conn) == 1) {
        skip('employee.php', 'ok', '修改成功！');
    }
    else {
        skip("employee_update.php?id={$_GET['id']}", 'error', '修改失败，请重试');
    }

}
$data = mysqli_fetch_assoc($result);
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">修改员工信息 ： <?php echo $data['lastName'], $data['firstName']?></div>
    <form method="post">
        <table class="au">
            <tr>
                <td>员工名称</td>
                <td><input name="lastName" value="<?php echo $data['lastName']?>" type="text" /></td>
                <td><input name="firstName" value="<?php echo $data['firstName']?>" type="text" /></td>
                <td class="note">
                    分别填入姓和名，不得超过30个字符
                </td>
            </tr>

            <tr>
                <td>性别</td>
                <td>
                    <select name="gender">
                        <option value="男" <?php if ($data['gender'] == "男") echo 'selected="selected"'; ?> >男</option>
                        <option value="女" <?php if ($data['gender'] == "女") echo 'selected="selected"'; ?> >女</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>手机号</td>
                <td><input name="phone" value="<?php echo $data['phone']?>" type="text" /></td>
                <td class="note">不超过11位</td>
            </tr>

            <tr>
                <td>邮箱</td>
                <td><input name="mail" value="<?php echo $data['mail']?>" type="text" /></td>
                <td class="note">选填</td>
            </tr>

            <tr>
                <td>城市</td>
                <td><input name="city" value="<?php echo $data['city']?>" type="text" /></td>
                <td class="note">选填</td>
            </tr>

            <tr>
                <td>地址</td>
                <td><input name="address" value="<?php echo $data['address']?>" type="text" /></td>
                <td class="note">选填</td>
            </tr>

            <tr>
                <td>职位</td>
                <td><input name="employee_position" value="<?php echo $data['employee_position']?>" type="text" /></td>
                <td class="note">选填</td>
            </tr>

        </table>
        <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>

