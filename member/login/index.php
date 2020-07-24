<?php
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();
//ワンタイムトークンの取得
$token = Safety::getToken();

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>商品一覧 | okashi days.</title>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../../index.php"><img src="../../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<nav class="nav">
			<ul>
				<li><a href="../../">ホーム</a></li>
                <li><a href="../../order/cart/">カート</a></li>
                <li><a href="../../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="./../item/list.php">商品一覧</a></li>
				<?php if(!isset($user)):?>
				<li><a href="../registration/">新規会員登録</a></li>
				<li><a href="../login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>

    <main>
        <?php
        if(isset($_SESSION['error']['member_login'])):?>
        <p class="error">
            <?= $_SESSION['error']['member_login'];?>
        </p>
        <?php endif;?>
        <form action="process.php" method="post">
            <!--ワンタイムトークンをpost-->
            <input type="hidden" name="token" value="<?= $token;?>">
            <table class="login">
                <tr>
                    <th class="login_field">
                        ユーザー名
                    </th>
                    <td class="login_field">
                        <input type="text" name="user_name" id="user" class="login_user" value="">
                    </td>
                </tr>
                <tr>
                    <th class="login_field">
                        パスワード
                    </th>
                    <td class="login_field">
                        <input type="password" name="password" id="password" class="login_pass" value="">
                    </td>
                </tr>
            </table>
            <input type="submit" value="ログイン" id="login">
        </form>
        <a href="../registration/">アカウントをお持ちでない方は新規会員登録へ</a>


    </main>

    <footer>
    <p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer>
</div>
</body>
</html>