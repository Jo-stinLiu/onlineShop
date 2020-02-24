<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';

$template['title'] = '注册';
$template['css'] = array('css/public.css', 'css/index.css');

$conn = connect();
$member_id = is_login($conn);
if ($member_id) {
    skip('index.php', 'error', '你已登录，请勿重复注册！');
}

if (isset($_POST['submit'])) {
    include 'inc/register_check.php';
    $query = "insert into member(username, password, photo, register_time, last_login_time) values('{$_POST['username']}', md5('{$_POST['password']}'), '', now(), now())";
    execute($conn, $query);
    if (mysqli_affected_rows($conn) == 1) {
        //设置cookie，默认有效时间3个小时
        setcookie('username', $_POST['username'], time() + 10800);
        //setcookie('password', sha1(md5($_POST['password'])));
        skip('index.php', 'ok', '注册成功！');
    }
    else {
        skip('register.php', 'error', '注册失败，请重试！');
    }
}
?>

<?php include 'inc/header.inc.php';?>
<div class="auto">
    <h2 style="text-align: center; font-size: large; color: black; padding-top: 25px">欢迎注册成为onlineShop的用户!</h2>

    <form method="post">
        <table class="list" style="text-align: center; margin: 20px auto">
            <tr>
                <td style="font-weight: bold; font-size: medium">用户名</td>
                <td><input type="text" name="username" id="user_name" style="width:236px; height: 25px"></td>
                <td><span class="note">&nbsp;- 用户名不得为空,不超过30个字符</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">密码</td>
                <td><input type="password" name="password" style="width:236px; height: 25px"></td>
                <td><span class="note">- 为保障安全,密码不能少于6位</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">确认密码</td>
                <td><input type="password" name="confirm_password" style="width:236px; height: 25px"></td>
                <td><span class="note">- 请重新输入密码,确认一致</span></td>
            </tr>
        </table>
        <div style="text-align: center; margin: 10px auto"><input type="submit" name="submit" class="btn" value="注册"></div>
    </form>

</div>

<?php
include 'inc/footer.inc.php';
?>

<script src="js/jquery.min.js"></script>

<script>
    $('#user_name').blur(function () {
        var username = $(this).val();
        if (username == '') {
            alert('用户名不能为空！');
        }
        else {
            $.ajax({
                type: "POST",
                url: 'confirm_username.php',
                data: {"user_name": username},
                success: function (data) {
                    var data_json = $.parseJSON(data);
                    if (data_json['flag'] == true) {
                        if (data_json['msg'] == 1) {
                            alert('该用户名已被使用！');
                            $('#user_name').val('');
                        }
                    }
                }
            });
        }
    });
</script>
</body>
</html>
