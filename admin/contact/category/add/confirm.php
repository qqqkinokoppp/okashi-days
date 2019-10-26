<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
//セッション開始
Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}
// var_dump($_SESSION['edituser']['id']);
// exit;

// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) 
{
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../../../error/error.php');
    exit;
}

//サニタイズ
$post = Common::sanitize($_POST);

//セッションにフォームから送られてきたデータを格納
$_SESSION['post']['add_contact_category'] = $post;

$_SESSION['error']['add_contact_category'] = '';

// var_dump($post);
// exit();
// var_dump($post['user_name']);
// exit;

//カテゴリ名が入力されていなかったら
if(empty($post['contact_category']))
{
    $_SESSION['error']['add_contact_category'] = 'カテゴリ名を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//カテゴリ名が50字以上だったら
if(mb_strlen($post['contact_category']) > 50)
{
    $_SESSION['error']['add_contact_category'] = 'カテゴリ名は50文字以内です。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お知らせカテゴリ登録確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お知らせカテゴリ登録確認</h1>
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
    <p>以下の内容で登録します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>カテゴリ名</th>
                    <td class="align-left">
                        <?= $post['contact_category'];?>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="contact_category" value="<?= $post['contact_category'];?>">
            <input type="submit" value="登録">
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>