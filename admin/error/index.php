<?php
// 設定クラスの読み込み
require_once("../../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
// セッションスタート
Session::sessionStart();
if(!isset($_SESSION['admin_user']))
{
    header('Location: ../../login/');
    exit;
}
else
{
    $user = $_SESSION['admin_user'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>エラー</title>
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>エラー</h1>
        </div>
        <div class="login_info">
            <ul>
                <li></li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <p class="error">
            申し訳ございません。エラーが発生しました。
            お手数ですが、ログインしなおしてお試しください。
        </p>
        <form>
            <input type="button" value="ログアウト" onclick="location.href='../login/';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>