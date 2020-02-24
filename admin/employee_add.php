<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$template['title'] = '添加员工';
$template['css'] = array('css/index.css');

if (isset($_POST['submit'])) {
    $check_type = 'add';
//    include 'inc/employee_check.inc.php';
    $query = "insert into employee (lastName, firstName, gender, phone, mail, city, address, employee_position) values ('{$_POST['lastName']}', '{$_POST['firstName']}', '{$_POST['gender']}', '{$_POST['phone']}', '{$_POST['mail']}', '{$_POST['city']}', '{$_POST['address']}', '{$_POST['employee_position']}')";
//    echo $query;
////    exit();
    execute($conn, $query);
    if (mysqli_affected_rows($conn) == 1) {
        skip('employee.php', 'ok', '员工添加成功！');
    }
    else {
        skip('employee_add.php', 'error', '员工添加失败，请重试！');
    }
}

?>
<?php include 'inc/header.inc.php'?>
    <div id="main">
        <div class="title" style="margin-bottom:20px;">添加员工</div>
        <form method="post">
            <table class="au">
                <tr>
                    <td>员工名称</td>
                    <td><input name="lastName" type="text" /></td>
                    <td><input name="firstName" type="text" /></td>
                    <td class="note">
                        分别填入姓和名，不得超过30个字符
                    </td>
                </tr>

                <tr>
                    <td>性别</td>
                    <td>
                        <select name="gender">
                            <option value="男" selected="selected">男</option>
                            <option value="女">女</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>手机号</td>
                    <td><input name="phone" type="text" /></td>
                    <td class="note">不超过11位</td>
                </tr>

                <tr>
                    <td>邮箱</td>
                    <td><input name="mail" type="text" /></td>
                    <td class="note">选填</td>
                </tr>

                <tr>
                    <td>城市</td>
                    <td><input name="city" type="text" /></td>
                    <td class="note">选填</td>
                </tr>

                <tr>
                    <td>地址</td>
                    <td><input name="address" type="text" /></td>
                    <td class="note">选填</td>
                </tr>

                <tr>
                    <td>职位</td>
                    <td><input name="employee_position" type="text" /></td>
                    <td class="note">选填</td>
                </tr>

            </table>
            <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
        </form>
    </div>
<?php include 'inc/footer.inc.php'?>
