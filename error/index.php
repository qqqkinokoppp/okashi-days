<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>okashi days.</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../"><img src="../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user)):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['first_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="../">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="../order/cart/">カート</a></li>
				<li><a href="../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="../item/list.php">商品一覧</a></li>
				<li><a href="./">お問い合わせ</a></li>
				<?php if(!isset($user)):?>
				<li><a href="../member/registration/">新規会員登録</a></li>
				<li><a href="../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
        <p>現在エラーが発生しております。ご迷惑をおかけしております。</p>
        <input type="button" value="戻る" onclick="history.back()">
	</main>
	<footer class="footer">
		<p>&copy;Copyright okashi days. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>