<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();
//ログインしているユーザーの情報を変数に格納
$user = $_SESSION['user'];


$post = Common::sanitize($_POST);
//修正したいユーザーのIDをセッションに保存
if(isset($post['user_id']))
{
$_SESSION['edituser']['id'] = $post['user_id'];
}

// $user_name = $_SESSION['edit_user']['user_name'];
// $emai = $_SESSION['edit_user']['email'];

$db = new Admin();

//ワンタイムトークンの取得
$token = Safety::getToken();
//POSTされてきたユーザーIDに該当するユーザー情報を取得してくる
$edit_user = $db ->getAdmin($_SESSION['edituser']['id']);
$user_name = $edit_user['user_name'];
$name = $edit_user['name'];
$email = $edit_user['email'];

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者情報修正</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>管理者情報修正</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <?php if(!empty($_SESSION['error']['adminedit'])):?>
        <p class="error">
            <?php print $_SESSION['error']['adminedit'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
        <!--ワンタイムトークン-->
        <input type="hidden" name="token" value="<?php print $token;?>">
            <table class="list">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php if(isset($user_name)):?>
                        <input type="text" name="user_name" id="item_name" class="item_name" value="<?php print $user_name?>">
                        <?php else:?>
                        <input type="text" name="user_name" id="item_name" class="item_name" value="">
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td class="align-left">
                    <input type="password" name="password" id="item_name" class="item_name" value="">
                    </td>
                </tr>
                <tr>
                    <th>確認用パスワード</th>
                    <td class="align-left">
                    <input type="password" name="password2" id="item_name" class="item_name" value="">
                    </td>
                </tr>
                <tr>
                    <th>管理者氏名</th>
                    <td class="align-left">
                    <?php if(isset($name)):?>
                    <input type="text" name="name" id="item_name" class="item_name" value="<?php print $name?>">
                    <?php else:?>
                    <input type="text" name="name" id="item_name" class="item_name" value="">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?php if(isset($email)):?>
                    <input type="text" name="email" id="item_name" class="item_name" value="<?php print $email?>">
                    <?php else:?>
                    <input type="text" name="email" id="item_name" class="item_name" value="">
                    <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?php print $token;?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>