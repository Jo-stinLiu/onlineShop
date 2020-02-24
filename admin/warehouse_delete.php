<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';
?>
<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('warehouse.php', 'error', 'id参数错误！');
}
//echo $_GET['id'], ' ', $_GET['warehouseName'];
//exit();
$query = "drop table {$_GET['warehouseName']};";
$query .= "delete from warehouseInfo where warehouseID={$_GET['id']};";
execute_multi($conn, $query);
if (!mysqli_error($conn)) {
    skip('warehouse.php', 'ok', '删除成功！');
}
else {
    skip('warehouse.php', 'error', '删除失败，请重试！');
}
?>
