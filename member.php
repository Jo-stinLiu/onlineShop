<?php

include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';

$template['title'] = '个人中心';
$template['css'] = array('css/public.css','css/member.css', 'css/index.css');

$conn = connect();
$member_id = is_login($conn);
$is_manage_login = is_manage_login($conn);

if(!isset($_GET['id'])){
    skip('index.php', 'error', '参数错误!');
}
$query = "select * from member where username='{$_GET['id']}'";
$result_member = execute($conn, $query);
if(mysqli_num_rows($result_member) != 1){
    skip('index.php', 'error', '该会员不存在!');
}
$data_member = mysqli_fetch_assoc($result_member);

$query = "select count(*) from shoppingOrder where customerID='{$_GET['id']}'";
$count_all = get_num($conn, $query);
$page_size = 6;
$page = page($count_all, $page_size, 5);
?>
<?php include 'inc/header.inc.php'?>
<div>
    <div id="shoppingRecord" style="border: black 2px solid; width: 70%; float: left; margin: 20px 3% 25px 3%; height: auto;">
        <div id="section"><div class="section_title">购物记录</div></div>
        <table class="list">
            <tr>
                <th>商品名称</th>
                <th>购买时间</th>
                <th>数量</th>
                <th>总价</th>
            </tr>
            <?php
            $query = "select * from shoppingOrder where customerID='{$_GET['id']}' order by orderTime {$page['limit']}";
            $result = execute($conn, $query);
            while ($data = mysqli_fetch_assoc($result)) {
                $productID = explode('-', "{$data['uniqueID']}")[0];
                $query = "select * from product where productID={$productID}";
                $pro_res = execute($conn, $query);
                $pro_data = mysqli_fetch_assoc($pro_res);
                $html=<<<DD
            <tr>
                <td><a class="ID" style="color: black" href="buy_product.php?id={$productID}">{$pro_data['productName']}</a></td>
                <td style="text-align: center; font-size: 18px; width: 200px">{$data['orderTime']}</td>
                <td style="text-align: center; font-size: 18px; width: 150px">{$data['num']}</td>
                <td style="text-align: center; font-size: 18px; width: 150px">{$data['totalPrice']}</td>
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

    <div id="member" style="border: black 2px solid; width: 21%; float: left;margin: 20px auto auto; height: auto;">
        <div style="text-align: center; margin: 30px auto">
            <img width="180" height="180" src="<?php if($data_member['photo']!=''){echo SUB_URL.$data_member['photo'];}else{echo 'css/photo.jpg';}?>">
        </div>
        <?php
        $html=<<<DD
        <table class="ulist">
            <tr>
                <td>姓名</td>
                <td>{$data_member['lastName']}{$data_member['firstName']}</td>
            </tr>
            <tr>
                <td>性别</td>
                <td>{$data_member['gender']}</td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td>{$data_member['mail']}</td>
            </tr>
            <tr>
                <td>手机</td>
                <td>{$data_member['phone']}</td>
            </tr>
            <tr>
                <td>地址</td>
                <td>{$data_member['address']}</td>
            </tr>
            <tr>
                <td>累积剁手金额</td>
                <td>{$data_member['cost']}</td>
            </tr>
        </table>
DD;
        echo $html;
        ?>
        <div style="margin: 20px auto; text-align: center">
            <a href="member_update.php" style="text-align: center; margin-right: 15px"><input type="button" name="submit" class="btn" value="更新个人信息"></a>
            <a href="member_photo_update.php" style="text-align: center"><input type="button" name="submit" class="btn" value="更新头像"></a>
        </div>


    </div>
</div>

<?php include 'inc/footer.inc.php'?>
