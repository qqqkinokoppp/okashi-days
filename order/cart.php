<?php
require_once("../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');


// セッションスタート
Session::sessionStart();
// if(!isset($_SESSION['user']))
// {
//     header('Location: ../../../login/');
// }
// else
// {
//     $user = $_SESSION['user'];
// }

$cart_items = $_SESSION['cart'];
//商品詳細データの取得
$db = new ItemManage();
$details = array();
var_dump($cart_items);
foreach($cart_items as $id =>$quantity)
{
    $details += $db ->getDetail($id);
}

var_dump($details);


//foreach用カウンターの初期化
$i = 0;

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>カート内の商品 | okashi days.</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../index.php"><img src="../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<nav class="nav">
			<ul>
				<li><a href="index.html">ホーム</a></li>
				<li><a href="about.html">店舗案内</a></li>
				<li><a href="access.html">アクセス</a></li>
				<li><a href="menu.html">商品一覧</a></li>
				<li><a href="contact.html">お問い合わせ</a></li>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
		<h2>カート内商品一覧</h2>
		<div class="menu-block">
			<?php foreach($details as $detail):?>
			<div class="menu-item">
				<div class="menu-photo">
					<img src="../admin/item/detail/img/<?= $detail['item_image'];?>" alt="">
				</div>
				<div class="menu-text">
					<a href="detail.php?id=<?= $detail['id'];?>"><h3><?= $detail['item_name']; ?></h3></a>
					<p><?= $detail['item_description']; ?></p>
					<p>&yen;<?= $detail['unit_price']; ?></p>
				</div>
			</div>
			<?php endforeach; ?>		
		</div>
	</main>
	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
	<p>&copy;Copyright Okashi days. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>