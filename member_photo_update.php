<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/upload.inc.php';

$template['title'] = '修改头像';
$template['css'] = array('css/public.css', 'css/index.css');

$conn = connect();
if(!$member_id = is_login($conn)){
    skip('login.php', 'error', '请先登录!');
}

$query = "select * from member where username='{$member_id}'";
$result_member = execute($conn,$query);
$data_member = mysqli_fetch_assoc($result_member);

if(isset($_POST['submit'])){
    $save_path = 'wwwroot/uploads'.date('/Y/m/d/');
    $upload = upload($save_path, '8M', 'photo');
    if($upload['return']) {
        $query = "update member set photo='{$upload['save_path']}' where username='{$member_id}'";
        execute($conn, $query);
        if(mysqli_affected_rows($conn) == 1) {
            skip("member.php?id={$member_id}",'ok','头像设置成功！');
        }else{
            skip('member_photo_update.php','error','头像设置失败，请重试！');
        }
    }else{
        skip('member_photo_update.php', 'error', $upload['error']);
    }
}

include 'inc/header.inc.php'
?>

<div id="main">
    <h2 style="text-align: center; font-size: large; color: black; padding-top: 25px">更改头像</h2>
    <div style="margin: 0 auto; text-align: center">
        <h3 style="text-align: center; font-size: medium; color: gray; padding-top: 25px">原头像：</h3>
        <img width=180 height=180 src="<?php if($data_member['photo']!=''){echo SUB_URL.$data_member['photo'];}else{echo 'css/photo.jpg';}?>" />
        <span style="display: block; color: gray">*建议图片尺寸：180*180</span>
    </div>
    <div style="margin: 20px auto; text-align: center">
        <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <input style="cursor:pointer;border: black 1px solid; height: 25px; border-radius: 6px" width="100" type="file" name="photo" />
                </tr>
            </table>
            <input class="submit btn btn-default" type="submit" name="submit" value="保存" />
        </form>
    </div>
</div>

<?php
include 'inc/footer.inc.php';
?>