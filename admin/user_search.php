<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$conn = connect();
include_once './inc/is_manage_login.inc.php';

$template['title'] = "用户搜索";
$template['css'] = array('css/index.css');
?>
<?php include 'inc/header.inc.php' ?>

<div id="main">
    <div class="title">搜索用户</div>

    <div id="register">
        <form action="" method="post">
            <label>用户名：<input type="text" name="username"></label>
            <input type="submit" name="submit" class="btn" value="搜索">
        </form>
    </div>

    <?php
    if(isset($_POST['submit'])) {
        $_POST = escape($conn, $_POST);
        //trim — Strip whitespace (or other characters) from the beginning and end of a string
        $username = trim($_POST['username']);
        $query = "select * from member where username like '%{$username}%'";
        $result = execute($conn, $query);
        $count_all = mysqli_num_rows($result);
        $result = execute($conn, $query);
    ?>
        <div class="title">搜索结果 - 共找到<?php echo $count_all; ?>个匹配的用户</div>

        <table class="list">
            <tr>
                <th>用户名</th>
                <th>注册时间</th>
                <th>操作</th>
            </tr>

            <?php
            while($data = mysqli_fetch_assoc($result)) {
                $url = urlencode("user_delete.php?id={$data['id']}");
                $return_url = urlencode($_SERVER['REQUEST_URI']);
                $message = "确定要删除用户 {$data['username']} 吗？";
                $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";

$html=<<<DD
                <tr>
                    <td>{$data['username']}</td>
                    <td>{$data['register_time']}</td>
                    <td><a target="_blank" href="../member.php?id={$data['username']}">[访问]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>
<!--                    <td><a href="$delete_url">[删除]</a></td>-->
                </tr>
DD;
                echo $html;
            }
            ?>
        </table>

    <?php
    }
    ?>

</div>

<?php include 'inc/footer.inc.php' ?>
