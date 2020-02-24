<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "更新仓库";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('warehouse.php', 'error', 'id参数错误');
}
$query = "select * from warehouseInfo where warehouseID={$_GET['id']}";
$result = execute($conn, $query);

if (!mysqli_num_rows($result)) {
    skip('warehouse.php', 'error', '该员工不存在！');
}
if (isset($_POST['submit'])) {
    $check_type = 'update';
//    include 'inc/warehouse_check.inc.php';
    $query = "rename table {$_GET['warehouseName']} to {$_POST['warehouseName']};";
    $query .= "update warehouseInfo set warehouseName='{$_POST['warehouseName']}', warehouseLocation='{$_POST['warehouseLocation']}', principal={$_POST['principal']} where warehouseID={$_GET['id']};";
//    echo $query;
//    exit();
    $result = execute_multi($conn, $query);
    if (!mysqli_error($conn)) {
        skip('warehouse.php', 'ok', '修改成功！');
    }
    else {
        skip("warehouse_update.php?id={$data['warehouseID']}&warehouseName={$data['warehouseName']}", 'error', '修改失败，请重试！');
    }
}

$data = mysqli_fetch_assoc($result);
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">修改仓库信息 ： <?php echo $data['warehouseName']?></div>
    <form method="post">
        <table class="au">
            <tr>
                <td>仓库名称</td>
                <td><input name="warehouseName" value="<?php echo $data['warehouseName'] ?>" type="text" /></td>
                <td class="note">不超过20个字符，不可与已有仓库重名</td>
            </tr>
            <tr>
                <td>仓库位置</td>
                <td><input name="warehouseLocation" value="<?php echo $data['warehouseLocation'] ?>" type="text" /></td>
                <td class="note">不超过255个字符</td>
            </tr>
            <tr>
                <td>仓库负责人</td>
                <td>
                    <select name="principal">
                        <option value="0">------请选择一个负责人------</option>
                        <?php
                        $query = "select * from employee where employee_position='仓库负责人'";
                        $result = execute($conn, $query);
                        while ($data_tem = mysqli_fetch_assoc($result)) {
                            $tem = $data_tem['id'] == $data['principal'];
//                            print_r($data_tem);
                            echo "<option value='{$data_tem['id']}'" . ($tem ? " selected='selected'" : "") . ">{$data_tem['lastName']}{$data_tem['firstName']}  [id:{$data_tem['id']}]</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="note">可后续修改</td>
            </tr>
        </table>
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>

