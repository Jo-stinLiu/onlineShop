<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once 'inc/upload.inc.php';

$template['title'] = "更新商品";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('product.php', 'error', 'id参数错误！');
}
$query = "select * from product where productID={$_GET['id']}";
$result = execute($conn, $query);
if (!mysqli_num_rows($result)) {
    skip('product.php', 'error', '该商品不存在！');
}
if (isset($_POST['submit'])) {
    //验证
    $check_type = 'update';
    $productName = escape($conn, $_POST['productName']);
    $description = escape($conn, $_POST['description']);
//    include 'inc/product_check.inc.php';

    if ($_FILES['photo']['size'] != 0) {
        $save_path = '../wwwroot/uploads'.date('/Y/m/d/');
        $upload = upload($save_path,'8M','photo');

        if($upload['return']) {
            $query = "update product set productID='{$_POST['productID']}', productName='{$productName}', productPrice={$_POST['productPrice']}, productImgURL='{$upload['save_path']}', description='{$description}', subDir_id={$_POST['subDir_id']} where productID={$_GET['id']}";
            execute($conn, $query);
            if(mysqli_affected_rows($conn) == 1) {
                skip('product.php', 'ok', '修改成功！');
            }
            else {
                skip("product_update.php?id={$_GET['id']}", 'error', '修改失败，请重试！');
            }
        }
        else {
            skip("product_update.php?id={$_GET['id']}", 'error', $upload['error']);
        }
    }
    else {
        $query = "update product set productID='{$_POST['productID']}', productName='{$productName}', productPrice={$_POST['productPrice']}, description='{$description}', subDir_id={$_POST['subDir_id']} where productID={$_GET['id']}";
        execute($conn, $query);
        if(mysqli_affected_rows($conn) == 1) {
            skip('product.php', 'ok', '修改成功！');
        }
        else {
            skip("product_update.php?id={$_GET['id']}", 'error', '修改失败，请重试！');
        }
    }
}
$data = mysqli_fetch_assoc($result);
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">修改商品</div>
    <form method="post" enctype="multipart/form-data">
        <table class="au">
            <tr>
                <td>商品名称</td>
                <td><input name="productName" type="text" value="<?php echo $data['productName']; ?>" /></td>
                <td class="note">不多于255个字符</td>
            </tr>
            <tr>
                <td>商品ID</td>
                <td><input name="productID" type="text" value="<?php echo $data['productID']; ?>" /></td>
                <td class="note">不多于255个字符，不可与已有商品ID重复</td>
            </tr>
            <tr>
                <td>商品价格</td>
                <td><input name="productPrice" type="text" value="<?php echo $data['productPrice']; ?>" /></td>
                <td class="note">不能是负数</td>
            </tr>
            <tr>
                <td>商品描述</td>
                <td><input name="description" type="text" value="<?php echo $data['description']; ?>" /></td>
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
                            $tem = $subDir_data['id'] == $data['subDir_id'];
                            echo "<option value='{$subDir_data['id']}'" . ($tem ? " selected='selected'" : "") . ">[{$dir_data['dirName']}]&nbsp;&nbsp;{$subDir_data['subDirName']}</option>";
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
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>


