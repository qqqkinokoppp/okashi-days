<?php
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();
//ワンタイムトークンの取得
$token = Safety::getToken();

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員ログイン</title>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
    <header>
        <h1>会員ログイン</h1>
    </header>

    <main>
        <?php
        if(isset($_SESSION['error']['member_login'])):?>
        <p class="error">
            <?php print $_SESSION['error']['member_login'];?>
        </p>
        <?php endif;?>
        <form action="process.php" method="post">
            <!--ワンタイムトークンをpost-->
            <input type="hidden" name="token" value="<?php print $token;?>">
            <table class="login">
                <tr>
                    <th class="login_field">
                        ユーザー名
                    </th>
                    <td class="login_field">
                        <input type="text" name="user_name" id="user" class="login_user" value="">
                    </td>
                </tr>
                <tr>
                    <th class="login_field">
                        パスワード
                    </th>
                    <td class="login_field">
                        <input type="password" name="password" id="password" class="login_pass" value="">
                    </td>
                </tr>
            </table>
            <input type="submit" value="ログイン" id="login">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>