<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$template['title'] = '添加仓库';
$template['css'] = array('css/index.css');

if (isset($_POST['submit'])) {
    $check_type = 'add';
//    include 'inc/warehouse_check.inc.php';
    $query=<<<DD
    insert into warehouseInfo(warehouseLocation, warehouseName, principal) values('{$_POST['warehouseLocation']}', '{$_POST['warehouseName']}', {$_POST['principal']});
    CREATE TABLE onlineShop.{$_POST['warehouseName']}  (
    uniqueID varchar(255) NOT NULL,
    num int(10) UNSIGNED NULL,
    PRIMARY KEY (uniqueID),
    FOREIGN KEY (uniqueID) REFERENCES onlineShop.productAttribute (uniqueID) ON DELETE CASCADE ON UPDATE CASCADE
    );
DD;
//    echo $query;
//    exit();
    $result = execute_multi($conn, $query);
    if (!mysqli_error($conn)) {
        skip('warehouse.php', 'ok', '仓库添加成功！');
    }
    else {
        skip('warehouse_add.php', 'error', '仓库添加失败，请重试！');
    }
}
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">添加仓库</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>仓库名称</td>
                <td><input name="warehouseName" type="text" /></td>
                <td class="note">不超过20个字符，不可与已有仓库重名</td>
            </tr>
            <tr>
                <td>仓库位置</td>
                <td><input name="warehouseLocation" type="text" /></td>
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
                        while ($tem = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$tem['id']}'>{$tem['lastName']}{$tem['firstName']}  [id:{$tem['id']}]</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="note">可后续修改</td>
            </tr>
        </table>
        <input style="margin-left:110px;margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php include 'inc/footer.inc.php' ?>

