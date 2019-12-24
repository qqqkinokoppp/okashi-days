<?php 
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

// セッションの開始
Session::sessionStart();

$add_member = $_SESSION['post']['add_member'];
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>新規会員登録 | okashi days.</title>
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
    <p>以下の内容で登録しました。</p>
    <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?= $add_member['user_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名(フリガナ)</th>
                    <td class="align-left">
                        <?= $add_member['last_name_kana'].' '.$add_member['first_name_kana'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名</th>
                    <td class="align-left">
                        <?= $add_member['last_name'].' '.$add_member['first_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>生年月日</th>
                    <td class="align-left">
                        <?= $add_member['birthday'];?>
                    </td>
                </tr>

                <tr>
                    <th>性別</th>
                    <td class="align-left">
                        <?php 
                        if($add_member['gender'] === '0')
                        {
                            print '男';
                        }
                        if($add_member['gender'] === '1')
                        {
                            print '女';
                        }
                        if($add_member['gender'] === '2')
                        {
                            print '回答しない';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?= $add_member['postal_code1'].'-'.$add_member['postal_code2'];?>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <?= $add_member['prefecture'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村・町名）</th>
                    <td class="align-left">
                    <?= $add_member['address1'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地・建物名）</th>
                    <td class="align-left">
                    <?= $add_member['address2'];?>
                    </td>
                </tr>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?= $add_member['phone_number'];?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?= $add_member['email'];?>
                    </td>
                    </tr>
            <!-- <input type="button" value="ログイン画面へ" onclick="location.href='../login/'"> -->
    </form>
        <input type="button" value="ログイン画面へ" onclick="location.href='../login/'">
    </main>

    <!-- <footer>
    <p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer> -->
</div>

</body>

<br>
<br>
</html>