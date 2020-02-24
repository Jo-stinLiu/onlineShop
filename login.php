<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title'] = '登录';
$template['css'] = array('css/public.css', 'css/index.css');

$conn = connect();
$member_id = is_login($conn);
if ($member_id) {
    skip('index.php', 'error', '你已经登录，请勿重复登录！');
}
if (isset($_POST['submit'])) {
    $_POST = escape($conn, $_POST);
    $query = "select * from member where username='{$_POST['username']}' and password=md5('{$_POST['password']}')";
    $result = execute($conn, $query);
    if (mysqli_num_rows($result) == 1) {

        session_start();

        setcookie('username', $_POST['username'], time() + $_POST['status_time']);
        skip('index.php', 'ok', '登录成功！');
    }
    else {
        skip('login.php', 'error', '用户名或密码错误！');
    }
}
?>

<?php include 'inc/header.inc.php' ?>
<div id="register" class="auto">
    <h2 style="text-align: center; font-size: large; color: black; padding-top: 25px">欢迎登录!</h2>
    <form method="post" actionn="">
        <table class="list" style="text-align: center; margin: 20px auto">
            <tr>
                <td style="font-weight: bold; font-size: medium">用户名</td>
                <td><input type="text" name="username" id="user_name" style="width:236px; height: 25px"></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">密码</td>
                <td><input type="password" name="password" style="width:236px; height: 25px;"></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">免登录</td>
                <td>
                    <select name="status_time" style="width:236px;height:25px;">
                        <option value="3600">1小时</option>
                        <option value="10800" selected="selected">3小时</option>
                        <option value="86400">一天</option>
                        <option value="604800">一周</option>
                        <option value="2592000">一个月</option>
                    </select>
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin: 10px auto"><input type="submit" name="submit" class="btn" value="登录"></div>
    </form>
</div>
<?php include 'inc/footer.inc.php' ?>

