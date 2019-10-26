<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

//サニタイズ
$post = Common::sanitize($_POST);

//修正したいユーザーのIDをセッションに保存
if(isset($user['id']))
{
    $_SESSION['id']['edit_password'] = $user['id'];
}

//ワンタイムトークンの取得
$token = Safety::getToken();


?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>パスワード修正 | okashi days.</title>
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
        <?php if(!empty($_SESSION['error']['edit_password'])):?>
        <p class="error">
            <?= $_SESSION['error']['edit_password'];?>
        </p>
        <?php endif;?>

        <form action="process.php" method="post">
            <table class="list">
                <tr>
                    <th>現在のパスワード</th>
                    <td class="align-left">
                    <input type="password" name="password_old" id="password_old" class="password_old" value="">
                    </td>
                </tr>
                <tr>
                    <th>新しいパスワード</th>
                    <td class="align-left">
                    <input type="password" name="password" id="password" class="password" value="">
                    </td>
                </tr>
                <tr>
                    <th>確認用パスワード</th>
                    <td class="align-left">
                    <input type="password" name="password2" id="password2" class="password2" value="">
                    </td>
                </tr>
                
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="パスワード変更">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>