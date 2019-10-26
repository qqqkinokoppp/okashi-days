<?php
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');

// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
}

$get = Common::sanitize($_GET);
$category_id = $get['id'];
$_SESSION['url'] = '../../item/list.php';
// if(!isset($_SESSION['user']))
// {
//     header('Location: ../../../login/');
// }
// else
// {
//     $user = $_SESSION['user'];
// }

//商品詳細データ、カテゴリの取得
$db = new ItemManage();
$details = $db ->getCategoryDetail($category_id);
$category = $db ->getCategory($category_id);

var_dump($details);
var_dump($category);

//foreach用カウンターの初期化
$i = 0;

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $category['item_category_name']?>カテゴリ商品一覧 | okashi days.</title>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../index.php"><img src="../../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user) === true):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['first_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="../../">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="../../order/cart/">カート</a></li>
				<li><a href="../category/">商品カテゴリ一覧</a></li>
				<li><a href="../list.php">商品一覧</a></li>
				<!-- <li><a href="contact.html">お問い合わせ</a></li> -->
				<?php if(!isset($user)):?>
				<li><a href="../../member/registration/">新規会員登録</a></li>
				<li><a href="../../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../../member/">会員ページ</a></li>
				<li><a href="../../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
		<h2><?= $category['item_category_name']?>カテゴリ商品一覧</h2>
		<div class="menu-block">
			<?php foreach($details as $detail):?>
			<div class="menu-item">
				<div class="menu-photo">
					<img src="../../admin/item/detail/img/<?= $detail['item_image'];?>" alt="">
				</div>
				<div class="menu-text">
					<a href="../detail.php?id=<?= $detail['id'];?>"><h3><?= $detail['item_name']; ?></h3></a>
					<p><?= $detail['item_description']; ?></p>
					<p>&yen;<?= $detail['unit_price']; ?></p>
				</div>
			</div>
			<?php endforeach; ?>		
		</div>
	</main>
	<input type="button" value="戻る" onclick="history.back()">
	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
		<p>&copy;Copyright KUJIRA Cafe. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>