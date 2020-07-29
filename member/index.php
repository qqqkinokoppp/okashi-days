<?php
require_once('../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');

Session::sessionStart();
if(!isset($_SESSION['user']))
{
     header('Location: ./login/index.php');   
}
else
{
    // var_dump($_SESSION['user']);
    // exit;
    $user = $_SESSION['user'];
}

//トップページでセッションを破棄
unset($_SESSION['error']);
unset($_SESSION['post']);
unset($_SESSION['before']);
unset($_SESSION['id']);
unset($_SESSION['token']);
//var_dump($_SESSION);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>商品一覧 | okashi days.</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../index.php"><img src="../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<nav class="nav">
			<ul>
				<li><a href="../">ホーム</a></li>
                <li><a href="../order/cart/">カート</a></li>
                <li><a href="../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="../item/list.php">商品一覧</a></li>
				<?php if(!isset($user)):?>
				<li><a href="../member/registration.php">新規会員登録</a></li>
				<li><a href="../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>

    <main>
    <table class="admin">
            <!-- <tr>
                <th colspan="2">会員情報変更・退会</th>
            </tr> -->
            <tr class="even">
            <h2>会員情報変更・退会</h2>
                <td>
                    <form action="edit/acount/" method="post">                       
                        <input type="submit" value="会員情報変更" class="btn-member">
                    </form>
                    <form action="edit/password/index.php" method="post">             
                        <input type="submit" value="パスワード変更" class="btn-member">
                    </form>
                    <form action="deactive/" method="post">
                        <input type="submit" value="退会" class="btn-member">
                    </form>
                </td>
            </tr>
        </table>

        <table class="admin">
            <tr class="even">
            <h2>購入履歴確認</h2>
                <td>
                    <form action="./order_history/" method="post">                       
                        <input type="submit" value="購入履歴確認" class="btn-member">
                    </form>
                </td>
            </tr>
        </table>

    </main>

    <footer>
    <p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer>
</div>
</body>
</html>