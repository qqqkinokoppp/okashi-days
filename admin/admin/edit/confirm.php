<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
//セッション開始
Session::sessionStart();
$user = $_SESSION['user'];
// var_dump($_SESSION['edituser']['id']);
// exit;

// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) {
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

//サニタイズ
$post = Common::sanitize($_POST);
$_SESSION['edit_user'] = $post;

$_SESSION['error']['adminedit'] = '';

// var_dump($post);
// exit();
// var_dump($post['user_name']);
// exit;

//ログインユーザー名が入力されていなかったら
if(empty($post['user_name']))
{
    $_SESSION['error']['adminedit'] = 'ログインユーザー名を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//パスワードが入力されていなかったら
if(empty($post['password']))
{
    $_SESSION['error']['adminedit'] = 'パスワードを入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//確認用パスワードが入力されていなかったら
if(empty($post['password2']))
{
    $_SESSION['error']['adminedit'] = '確認用パスワードを入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//管理者氏名が入力されていなかったら
if(empty($post['name']))
{
    $_SESSION['error']['adminedit'] = '管理者氏名を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//メールアドレスが入力されていなかったら
if(empty($post['email']))
{
    $_SESSION['error']['adminedit'] = 'メールアドレスを入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//パスワードが一致するかどうかの確認
if(!($post['password'] === $post['password2']))
{
    $_SESSION['error']['adminedit'] = 'パスワードが一致しません。';
    //print '通った';
    //exit;
    header('Location:./index.php');
    exit;
}

//パスワードのバリデーション
if(((preg_match('/^[a-zA-Z0-9]+$/',$post['password'])) === 0)||(preg_match('/^[a-zA-Z0-9]+$/',$post['password2'])) === 0)
{
    $_SESSION['error']['adminedit'] = 'パスワードは半角英数で入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//ログインユーザー名のバリデーション
if(preg_match('/^[a-zA-Z0-9]+$/', $post['user_name']) === 0)
{
    $_SESSION['error']['adminedit'] = 'ログインユーザー名は半角英数で入力してください。';
    header('Location:./index.php');
    exit;
}

//メールアドレスのバリデーション
if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false)
{
    $_SESSION['error']['adminedit'] = 'メールアドレスを正しく入力してください。';
    header('Location:./index.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者情報修正確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>管理者情報修正確認</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
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
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php print $post['user_name'];?>
                    </td>
                </tr>
             
                <!--tr>
                    <th>パスワード</th>
                    <td class="align-left">
                    <input type="text" name="item_name" id="item_name" class="item_name" value="">
                    </td>
                </tr>
                <tr>
                    <th>確認用パスワード</th>
                    <td class="align-left">
                    <input type="text" name="item_name" id="item_name" class="item_name" value="">
                    </td>
                </tr>-->
                <tr>
                    <th>管理者氏名</th>
                    <td class="align-left">
                        <?php print $post['name'];?>
                    <!--<input type="text" name="item_name" id="item_name" class="item_name" value="">-->
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?php print $post['email'];?>
                    <!--<input type="text" name="item_name" id="item_name" class="item_name" value="">-->
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