<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/upload.inc.php';

$template['title'] = '修改信息';
$template['css'] = array('css/public.css', 'css/index.css');

$conn = connect();
if(!$member_id = is_login($conn)){
    skip('login.php', 'error', '请先登录!');
}

if (isset($_POST['submit'])) {
    $check_type = 'update';
//    include 'inc/member_check.inc.php';
    $query = "update member set lastName='{$_POST['lastName']}', firstName='{$_POST['firstName']}', gender='{$_POST['gender']}', mail='{$_POST['mail']}', phone={$_POST['phone']}, address='{$_POST['address']}' where username='{$member_id}'";
    $result = execute($conn, $query);
    if (mysqli_affected_rows($conn) == 1) {
        skip("member.php?id={$member_id}", 'ok', '修改成功！');
    }
    else {
        skip("member_update.php", 'error', '修改失败，请重试');
    }
}

include 'inc/header.inc.php'
?>
<div id="register" class="auto">
    <h2 style="text-align: center; font-size: large; color: black; padding-top: 25px">修改信息</h2>
    <form method="post" actionn="">
        <table class="list" style="text-align: center; margin: 20px auto">
            <?php
            $query = "select * from member where username='{$member_id}'";
            $result = execute($conn,$query);
            $data = mysqli_fetch_assoc($result);

            $html=<<<DD
            <tr>
                <td style="font-weight: bold; font-size: medium">姓</td>
                <td><input name="lastName" value="{$data['lastName']}" type="text" style="width:236px; height: 25px" /></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">名</td>
                <td><input name="firstName" value="{$data['firstName']}" type="text" style="width:236px; height: 25px" /></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">性别</td>
                <td><input name="gender" value="{$data['gender']}" type="text" style="width:236px; height: 25px" /></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">邮箱</td>
                <td><input name="mail" value="{$data['mail']}" type="text" style="width:236px; height: 25px" /></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">电话</td>
                <td><input name="phone" value="{$data['phone']}" type="text" style="width:236px; height: 25px" /></td>
            </tr>
            <tr>
                <td style="font-weight: bold; font-size: medium">地址</td>
                <td><input name="address" value="{$data['address']}" type="text" style="width:236px; height: 25px" /></td>
            </tr>
DD;
            echo $html;
            ?>
        </table>
        <div style="text-align: center; margin: 10px auto"><input type="submit" name="submit" class="btn" value="修改"></div>
    </form>
</div>
<?php include 'inc/footer.inc.php' ?>


