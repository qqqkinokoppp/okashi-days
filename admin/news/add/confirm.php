<?php 
require_once('../../../../Config.php');
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
$_SESSION['post']['add_news'] = $post;

$_SESSION['error']['add_news'] = '';

//お知らせ見出しが入力されていなかったら
if(empty($post['news_index']))
{
    $_SESSION['error']['add_news'] = 'お知らせ見出しを入力してください。';
    header('Location:./index.php');
    exit;
}

//お知らせ見出しが100文字超えていれば
if(strlen($post['news_index'])>500)
{
    $_SESSION['error']['add_news'] = 'お知らせ見出しは100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//お知らせ内容が入力されていなかったら
if(empty($post['news_content']))
{
    $_SESSION['error']['add_news'] = 'お知らせ内容を入力してください。';
    header('Location:./index.php');
    exit;
}

//お知らせ内容が250文字超えていれば
if(strlen($post['news_index'])>250)
{
    $_SESSION['error']['add_news'] = 'お知らせ内容は250文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//掲載期限日が今日より前に設定されていたら 2019/9/7ここまで！！！！
if(isset($post['expiration_date']))
{
    if($post['expiration_date']<date('y/m/d'))
    {
        $_SESSION['error']['add_news'] = '掲載期限日は今日以降の日付にしてください。';
        header('Location:./index.php');
        exit;
    }

}
else
{
    $_SESSION['post']['add_news']['expiration_date'] = date('y/m/d', strtotime('+1 month'));
}

//パスワードが一致するかどうかの確認
if(!($post['password'] === $post['password2']))
{
    $_SESSION['error']['add_news'] = 'パスワードが一致しません。';
    //print '通った';
    //exit;
    header('Location:./index.php');
    exit;
}

//パスワードのバリデーション
if(((preg_match('/^[a-zA-Z0-9]+$/',$post['password'])) === 0)||(preg_match('/^[a-zA-Z0-9]+$/',$post['password2'])) === 0)
{
    $_SESSION['error']['add_news'] = 'パスワードは半角英数で入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//ログインユーザー名のバリデーション
if(preg_match('/^[a-zA-Z0-9]+$/', $post['user_name']) === 0)
{
    $_SESSION['error']['add_news'] = 'ログインユーザー名は半角英数で入力してください。';
    header('Location:./index.php');
    exit;
}

//メールアドレスのバリデーション
if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false)
{
    $_SESSION['error']['add_news'] = 'メールアドレスを正しく入力してください。';
    header('Location:./index.php');
    exit;
}

$_SESSION['adduser'] = $post;


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者登録確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>管理者登録確認</h1>
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
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?= $post['user_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>管理者氏名</th>
                    <td class="align-left">
                        <?= $post['name'];?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?= $post['email'];?>
                    </td>
                </tr>

            </table>
            <input type="submit" value="登録">
            
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>