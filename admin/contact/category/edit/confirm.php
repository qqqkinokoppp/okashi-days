<?php 
//設定ファイルの読み込み
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッション開始
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

// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) {
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

//サニタイズ
$post = Common::sanitize($_POST);
// var_dump($_SESSION);
$_SESSION['post']['edit_contact_category'] = $post;

//エラーメッセージの初期化
$_SESSION['error']['edit_category'] = '';

var_dump($post);
//お問い合わせカテゴリ名が入力されていなかったら
if(empty($post['edit_contact_category']))
{
    $_SESSION['error']['edit_contact_category'] = 'お問い合わせカテゴリ名を入力してください。';
    header('Location:./index.php');
    exit;
}

// 50文字以上であれば
if(mb_strlen($post['edit_contact_category']) >50)
{
    $_SESSION['error']['edit_contact_category'] = 'お問い合わせカテゴリ名は50文字以内です。';
    header('Location:./index.php');
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お問い合わせカテゴリ修正確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お問い合わせカテゴリ修正確認</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の内容で修正します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>お問い合わせカテゴリ名</th>
                    <td class="align-left">
                        <?= $post['edit_contact_category'];?>
                        <?php $_SESSION['post']['edit_contact_category']['contact_category'] = $post['edit_contact_category'];?>
                        <input type="hidden" value="<?= $_SESSION['id']['edit_contact_category'];?>">
                    </td>
                </tr>
                <!-- <?php var_dump($_SESSION['post']['edit_category']);?> -->

            </table>
            <input type="submit" value="修正">
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>