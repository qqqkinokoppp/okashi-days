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

$db = new ItemManage();

//商品カテゴリの取得
$categories = $db ->getCategoryAll();

//foreach用カウンターの初期化
$i = 0;

// var_dump($categories);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>商品カテゴリ一覧 | okashi days.</title>
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
				<li><a href="./">商品カテゴリ一覧</a></li>
				<li><a href="../../item/list.php">商品一覧</a></li>
				<li><a href="../../contact/">お問い合わせ</a></li>
				<!-- <li><a href="contact.html">お問い合わせ</a></li> -->
				<?php if(!isset($user)):?>
				<li><a href="../../contact/">新規会員登録</a></li>
				<li><a href="../../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../../member/">会員ページ</a></li>
				<li><a href="../../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>

    <main>
        <h2>商品カテゴリ一覧</h2>
            <?php foreach($categories as $category):?>
                    <a href="./list.php?id=<?= $category['id']?>">
                    <img src="../../admin/item/category/img/<?= $category['item_category_image']?>" width="25%" height="auto">
                    <?= $category['item_category_name'];?>
                    </a>
                    <br>
            <?php $i++;?>
            <?php endforeach;?>
        </table>
        <input type="button" value="戻る" onclick="location.href='../../';">

    </main>

    <footer>
	<p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer>
</div>
</body>
</html>