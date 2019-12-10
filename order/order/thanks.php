<?php
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');

// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    // var_dump($user);
    // exit;
}
else
{
    header('Location: ../../member/login/');
    exit;
}

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Thanks! | okashi days.</title>
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
				<li><a href="../cart/">カート</a></li>
				<li><a href="../../item/category/">商品カテゴリ一覧</a></li>
				<!-- <li><a href="access.html">アクセス</a></li> -->
				<li><a href="../../item/list.php">商品一覧</a></li>
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
		<h2>ご購入ありがとうございました！</h2>
		
        <form action="../../" method="post">
        <input type="submit" value="トップページへ" class="btn-totop"> 
        </form>

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

