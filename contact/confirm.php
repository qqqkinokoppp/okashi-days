<?php
require_once('../../Config.php');
require_once(Config::APP_ROOT_DIR . 'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR . 'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR . 'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR . 'classes/model/ContactManage.php');
// セッション開始
Session::sessionStart();

//サニタイズ
$post = Common::sanitize($_POST);

// var_dump($_SESSION['token']);
// var_dump($_POST['token']);
// exit;
$_SESSION['post']['contact'] = $post;
$_SESSION['post']['contact']['postal_code'] = $post['postal_code1'] . $post['postal_code2'];

// var_dump($_SESSION['post']['contact']);
// exit;

//ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) 
{
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

//ログインユーザー名が入力されていなかったら
if (empty($post['name'])) 
{
    $_SESSION['error']['contact'] = 'お名前を入力してください。';
    print '通った1';
    // exit;
    header('Location:./');
    exit;
}

//郵便番号が入力されていなかったら
if (empty($post['postal_code1']) || empty($post['postal_code2'])) 
{
    $_SESSION['error']['contact'] = '郵便番号を入力してください。';
    print '通った10';
    // exit;
    header('Location:./');
    exit;
}

//住所1が入力されていなかったら
if (empty($post['address1'])) 
{
    $_SESSION['error']['contact'] = '住所1（市区町村）を入力してください。';
    print '通った11';
    // exit;
    header('Location:./');
    exit;
}

// //電話番号が入力されていなかったら
// if (empty($post['phone_number'])) {
//     $_SESSION['error']['contact'] = '電話番号を入力してください。';
//     print '通った12';
//     exit;
//     header('Location:./index.php');
//     exit;
// }


//メールアドレスが入力されていなかったら
if (empty($post['email'])) 
{
    $_SESSION['error']['contact'] = 'メールアドレスを入力してください。';
    print '通った13';
    // exit;
    header('Location:./');
    exit;
}

//メールアドレスのバリデーション
if (filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false) 
{
    $_SESSION['error']['contact'] = 'メールアドレスを正しく入力してください。';
    header('Location:./');
    exit;
}

//電話番号のバリデーション
if (preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $post['phone_number']) === 0) 
{
    $_SESSION['error']['contact'] = '電話番号を正しく入力してください。';
    header('Location:./');
    exit;
}

// お問い合わせ内容のバリデーション
if(mb_strlen($post['contact_content']) >= 1000)
{
    $_SESSION['error']['contact'] = 'お問い合わせ内容は1000文字以内となっております。';
    header('Location:./');
    exit;
}

// 問い合わせの種類、きっかけ取得
$db = new ContactManage();
$contact_category = $db ->getContactCategory($post['contact_category_id']);
$contact_trigger = $db ->getTrigger($post['contact_trigger_id']);
var_dump($contact_category);
var_dump($contact_trigger);
var_dump($_SESSION['post']['contact']);

// $_SESSION['post']['contact'] = $post;
// $_SESSION['post']['contact']['postal_code'] = $post['postal_code1'] . $post['postal_code2'];

// エラーメッセージの初期化
$_SESSION['error'] = '';

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>お問い合わせ内容の確認 | okashi days.</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../index.php"><img src="../images/okashi_days_logo.png" alt="okashi days."></a></h1>
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
    <p>以下の内容で送信します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>お名前</th>
                    <td class="align-left">
                        <?= $post['name'];?>
                    </td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?= $post['postal_code1'].'-'.$post['postal_code2'];?>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <?= $post['prefecture'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村・町名）</th>
                    <td class="align-left">
                    <?= $post['address1'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地・建物名）</th>
                    <td class="align-left">
                    <?= $post['address2'];?>
                    </td>
                </tr>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?= $post['phone_number'];?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?= $post['email'];?>
                    </td>
                </tr>
                <tr>
                    <th>当サイトを知ったきっかけ</th>
                    <td class="align-left">
                    <?= $contact_trigger['contact_trigger'];?>
                    </td>
                </tr>
                <tr>
                    <th>お問い合わせの種類</th>
                    <td class="align-left">
                    <?= $contact_category['contact_category'];?>
                    </td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td class="align-left">
                    <?= $post['contact_content'];?>
                    </td>
                </tr>

            </table>
            <input type="submit" value="送信">
            
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>