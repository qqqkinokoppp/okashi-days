<?php
require_once("../../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Order.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Member.php');


// セッションスタート
Session::sessionStart();
if(!isset($_SESSION['admin_user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['admin_user'];
}

// 購入履歴確認する会員のID
$post = Common::sanitize($_POST);
$customer_id = $post['user_id'];

$order = new Order();
$order_histories = $order ->getMemberOrder($customer_id);
// var_dump($order_histories);

$member = new Member();
$member_info = $member ->getMember($customer_id);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員購入履歴確認</title>
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/main.css">
</head>
<body>
<div class="container">
    <header>
        <div class="title">
            <h1>会員購入履歴確認</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
                    </form>
                </li>
            </ul>
        </div>
    </header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
		<h2><?= $member_info['last_name'].' '.$member_info['first_name'].'様の'?>購入履歴</h2>
		<div class="menu-block">
			<?php if(empty($order_histories)):?>
			<p>購入履歴がありません。</p>
			<?php endif;?>
            <table class=item>
                <th>商品名</th>
                <th>単価</th>
                <th>数量</th>
                <th>小計</th>
                <th>購入日</th>
                <?php $i = 0;?>
			<?php foreach($order_histories as $order_history):?>
                <?php if($i%2 === 0):?>
                <tr class="even">
                <?php else:?>
                <tr class="odd">
                <?php endif;?>
                <td><?= $order_history['item_name']?></td>
                <td>&yen;<?= $order_history['unit_price']?></td>
                <td><?= $order_history['quantity']?>個</td>
                <td>&yen;<?= $order_history['subtotal']; ?></td>
                <?php $date = new DateTime($order_history['order_date_time']);?>
                <td><?= $date ->format('Y-m-d');?></td>
                </tr>
                <?php $i++?>
            <?php endforeach;?>
            </table>		
		</div>
	</main>

    <input type="button" value="戻る" onclick="history.back()">
    

	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>