<?php 
//設定ファイルの読み込み
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッションの開始
Session::sessionStart();

if(!isset($_SESSION['user']))
{
    header('Location: ../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お問い合わせCSVダウンロード</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お問い合わせCSVダウンロード</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <p>ダウンロードしたい注文日を選んでください。</p>
    <form action="./process.php" method="post">
        <input type="date" name="download" value="<?php echo date('Y-m-j');?>">
        <input type="submit" value="CSVダウンロード">
        <!-- ワンタイムトークン -->
        <input type="hidden" name="token" value="<?= Safety::getToken();?>">
    </form>

    <form>
        <input type="button" value="管理者トップページへ" onclick="location.href='../';">
    </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>