<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = "目录列表";
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';
?>

<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title">目录列表</div>
    <table class="list">
        <tr>
            <th>目录名称</th>
            <th>优先级</th>
            <th>操作</th>
        </tr>
        <?php
        //按优先级排序
        $query = 'select * from dirInfo order by sort desc';
        $result = execute($conn, $query);
        while($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("dirInfo_delete.php?id={$data['id']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "确定要删除目录 {$data['dirName']} 吗？";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
            //echo $delete_url;
            $html=<<<DD
        <tr>
            <td>{$data['dirName']}&nbsp;[id:&nbsp;{$data['id']}]</td>
            <td>{$data['sort']}</td>
<!--            <td><a target="_blank" href="../list_dirInfo.php?id={$data['id']}">[访问]</a>&nbsp;&nbsp;<a href="dirInfo_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>-->
            <td><a href="dirInfo_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>
        </tr>
DD;
            echo $html;
        }
        ?>
    </table>
</div>
<?php include 'inc/footer.inc.php'?>
