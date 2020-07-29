<?php 
require_once('../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

Session::sessionStart();
$user = $_SESSION['user'];

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>パスワード修正完了 | okashi days.</title>
<link rel="stylesheet" href="../../../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../../../index.php"><img src="../../../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<nav class="nav">
			<ul>
				<li><a href="../../">ホーム</a></li>
				<li><a href="../../order/cart/">カート</a></li>
				<li><a href="../../../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="./../item/list.php">商品一覧</a></li>
				<?php if(!isset($user)):?>
				<li><a href="./registration.php">新規会員登録</a></li>
				<li><a href="../login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>


    <main>
    <p>パスワードを修正しました。</p>
            <input type="button" value="戻る" onclick="location.href='../../'">
        </form>


    </main>

    <footer>
	<p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer>
</div>
</body>
</html>