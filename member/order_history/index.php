<?php
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Order.php');


// セッションスタート
Session::sessionStart();

$_SESSION['url'] = '../../order/cart/';
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

$db = new Order();
$order_histories = $db ->getMemberOrder($user['id']);
// var_dump($order_histories);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>購入履歴 | okashi days.</title>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../../"><img src="../../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user) === true):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['first_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="../../">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="../../order/cart/">カート</a></li>
				<li><a href="../../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="../../item/list.php">商品一覧</a></li>
				<!-- <li><a href="contact.html">お問い合わせ</a></li> -->
				<?php if(!isset($user)):?>
				<li><a href="contact.html">新規会員登録</a></li>
				<li><a href="../login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../">会員ページ</a></li>
				<li><a href="../login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
		<h2>購入履歴</h2>
		<div class="menu-block">
			<?php if(empty($order_histories)):?>
			<p>購入履歴がありません。</p>
			<?php endif;?>
			<?php foreach($order_histories as $order_history):?>
			<div class="menu-item">
				<div class="menu-photo">
					<img src="../../admin/item/detail/img/<?= $order_history['item_image'];?>" alt="" width="50%" height="auto">
				</div>
				<div class="menu-text">
					<a href="../../item/detail.php?id=<?= $order_history['item_id'];?>"><h3><?= $order_history['item_name']; ?></h3></a>
                    <p>数量：<?= $order_history['quantity'];?>個</p>
                    <p>単価：&yen;<?= $order_history['unit_price']; ?></p>
                    <p>小計：&yen;<?= $order_history['subtotal']; ?></p>
                    <?php $date = new DateTime($order_history['order_date_time']);
                    // var_dump($date);
                    ?>
                    <p>購入日：<?= $date ->format('Y-m-d');?></p>
				</div>
			</div>
			<?php endforeach; ?>		
		</div>
	</main>

    <input type="button" value="戻る" onclick="history.back()">
    

	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
	<p>&copy;Copyright Okashi days. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>