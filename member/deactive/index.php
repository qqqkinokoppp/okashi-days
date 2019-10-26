<?php 
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();
//ログインしているユーザーの情報を変数に格納
if(!isset($_SESSION['user']))
{
    header('Location: ../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

// 退会する会員のIDをセッションに格納
$_SESSION['id']['deactive_member'] = $_SESSION['user']['id'];

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>退会確認 | okashi days.</title>
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
                <li><a href="../../order/cart/">カート</a></li>
                <li><a href="../../item/category/">商品カテゴリ一覧</a></li>
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
<body>
<div class="container">
    <header>
         <div class="title">
            <h2>会員退会確認</h2>
        </div>
        <div class="login_info">
        </div>
    </header>

    <main>
    <p>退会しますか？</p>

        <form action="process.php" method="post">
            <input type="submit" value="退会する">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>