<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "员工信息";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';
?>

<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title">员工列表</div>
    <table class="list">
        <tr>
<!--            <th>id</th>-->
            <th>姓名</th>
            <th>性别</th>
            <th>手机号</th>
            <th>邮箱</th>
            <th>城市</th>
            <th>地址</th>
            <th>职位</th>
            <th>操作</th>
        </tr>

        <?php
        $query = "select * from employee";
        $result = execute($conn, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("employee_delete.php?id={$data['id']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "确定要删除员工 {$data['lastName']}{$data['firstName']} 吗？";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
            $html=<<<DD
        <tr>
<!--            <td>{$data['id']}</td>-->
            <td>{$data['lastName']}{$data['firstName']}</td>
            <td>{$data['gender']}</td>
            <td>{$data['phone']}</td>
            <td>{$data['mail']}</td>
            <td>{$data['city']}</td>
            <td>{$data['address']}</td>
            <td>{$data['employee_position']}</td>
            <td><a href="employee_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href=$delete_url>[删除]</a></td>
        </tr>   
DD;
            echo $html;
        }
        ?>
    </table>
</div>
