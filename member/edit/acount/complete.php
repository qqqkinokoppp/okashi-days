<?php 
require_once('../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

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
$edit_member = $_SESSION['post']['edit_member'];

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>会員情報修正完了 | okashi days.</title>
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
    <p>以下の内容で修正しました。</p>
            <table class="list" height="200">
            <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?= $edit_member['user_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名(フリガナ)</th>
                    <td class="align-left">
                        <?= $edit_member['last_name_kana'].' '.$edit_member['first_name_kana'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名</th>
                    <td class="align-left">
                        <?= $edit_member['last_name'].' '.$edit_member['first_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?= $edit_member['postal_code1'].'-'.$edit_member['postal_code2'];?>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <?= $edit_member['prefecture'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村・町名）</th>
                    <td class="align-left">
                    <?= $edit_member['address1'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地・建物名）</th>
                    <td class="align-left">
                    <?= $edit_member['address2'];?>
                    </td>
                </tr>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?= $edit_member['phone_number'];?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?= $edit_member['email'];?>
                    </td>
                </tr>

            </table>
            <input type="button" value="戻る" onclick="location.href='../../'">
        </form>


    </main>

    <footer>
    <p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer>
</div>
</body>
</html>