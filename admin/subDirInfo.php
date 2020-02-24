<?php

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.inc.php';

$template['title'] = '子目录列表';
$template['css'] = array('css/index.css');

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$query = "select count(*) from subDirInfo";
$count_res = get_num($conn, $query);
//一页6个
$page_size = 6;
$page = page($count_res, $page_size, 5);
?>

<?php include 'inc/header.inc.php'?>

<div id="main">
    <div class="title">子目录列表</div>
    <div style="margin: 20px auto; text-align: center">
        <?php
        if (!isset($_GET['sorted'])) {
            $html=<<<DD
        <a><button type="button" class="btn btn-default focus" style="margin-right: 30px">按优先级排序</button></a>
        <a href="subDirInfo.php?sorted=id"><button type="button" class="btn btn-default">按id排序</button></a>
DD;
        }
        else {
            $html=<<<DD
        <a href="subDirInfo.php"><button type="button" class="btn btn-default" style="margin-right: 30px">按优先级排序</button></a>
        <a><button type="button" class="btn btn-default focus">按id排序</button></a>
DD;
        }
        echo $html;
        ?>
    </div>

    <table class="list">
        <tr>
            <th>子目录名称</th>
            <th>所属目录</th>
            <th>子目录优先级</th>
            <th>所属目录优先级</th>
            <th>操作</th>
        </tr>
        <?php
        if (!isset($_GET['sorted'])) {
            $query = "select subDirInfo.id, subDirName, dirName, dirInfo.sort as d_sort, subDirInfo.sort as sd_sort from subDirInfo join dirInfo on dir_id = dirInfo.id order by dirInfo.sort desc, subDirInfo.sort desc {$page['limit']}";
        }
        else {
            $query = "select subDirInfo.id, subDirName, dirName, dirInfo.sort as d_sort, subDirInfo.sort as sd_sort from subDirInfo join dirInfo on dir_id = dirInfo.id order by id {$page['limit']}";
        }
        $result = execute($conn, $query);

        while ($data = mysqli_fetch_assoc($result)) {
//            print_r($data);
            $url = urlencode("subDirInfo_delete.php?id={$data['id']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "确定要删除子目录 {$data['subDirName']} 吗？";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";

$html = <<<DD
        <tr>
            <td>{$data['subDirName']}&nbsp;[id:&nbsp;{$data['id']}]</td>
            <td>{$data['dirName']}</td>
            <td>{$data['sd_sort']}</td>
            <td>{$data['d_sort']}</td>
<!--            <td><a target="_blank" href="../list_son.php?id={$data['id']}">[访问]</a>&nbsp;&nbsp;<a href="son_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="{$delete_url}">[删除]</a></td>-->
            <td><a href="subDirInfo_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="{$delete_url}">[删除]</a></td>
        </tr>
DD;
            echo $html;
        }
        ?>
    </table>

    <div class="pages_wrap_show">
        <div class="pages">
            <?php
            echo $page['html'];
            ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.inc.php'?>



