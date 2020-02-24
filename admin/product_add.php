<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once 'inc/upload.inc.php';

$template['title'] = "添加商品";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (isset($_POST['submit'])) {
    //验证
    $check_type = 'add';
//    include 'inc/product_check.inc.php';
    $productName = escape($conn, $_POST['productName']);
    $description = escape($conn, $_POST['description']);

    $save_path = '../wwwroot/uploads'.date('/Y/m/d/');
    $upload = upload($save_path,'8M','photo');
    if($upload['return']) {
//        echo $upload['save_path'];
        $query = "insert into product(productID, productName, productPrice, productImgURL, description, subDir_id) values('{$_POST['productID']}', '{$productName}', {$_POST['productPrice']}, '{$upload['save_path']}', '{$description}', {$_POST['subDir_id']})";
        execute($conn, $query);
        if(mysqli_affected_rows($conn) == 1) {
            skip("productAttribute.php?id={$_POST['productID']}", 'ok', '商品添加成功！');
        }
        else {
            skip('product_add.php', 'error', '商品添加失败，请重试！');
        }
    }
    else {
        skip('product_add.php', 'error', $upload['error']);
    }
}
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">添加商品</div>
    <form method="post" enctype="multipart/form-data">
        <table class="au">
            <tr>
                <td>商品名称</td>
                <td><input name="productName" type="text" /></td>
                <td class="note">不多于255个字符</td>
            </tr>
            <tr>
                <td>商品ID</td>
                <td><input name="productID" type="text" /></td>
                <td class="note">不多于255个字符，不可与已有商品ID重复</td>
            </tr>
            <tr>
                <td>商品价格</td>
                <td><input name="productPrice" type="text" /></td>
                <td class="note">不能是负数</td>
            </tr>
            <tr>
                <td>商品描述</td>
                <td><textarea name="description" ></textarea></td>
                <td class="note">不多于255个字符</td>
            </tr>

            <tr>
                <td>所属子目录</td>
                <td>
                    <select name="subDir_id">
                        <option value="0">------请选择一个子目录------</option>
                        <?php
                        $query = "select * from subDirInfo order by dir_id";
                        $result = execute($conn, $query);
                        while ($subDir_data = mysqli_fetch_assoc($result)) {
                            $query = "select * from dirInfo where id={$subDir_data['dir_id']}";
                            $dir_result = execute($conn, $query);
                            $dir_data = mysqli_fetch_assoc($dir_result);
                            echo "<option value='{$subDir_data['id']}'>[{$dir_data['dirName']}]&nbsp;&nbsp;{$subDir_data['subDirName']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="note">选择一个子目录，如果没有，请先添加子目录</td>
            </tr>

            <tr>
                <td>上传图片</td>
                <td>
                    <input style="cursor:pointer;" title="choose a picture" type="file" name="photo" />
                </td>
                <td class="note">图片大小要小于8M</td>
            </tr>
        </table>

        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit"  value="添加" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>
