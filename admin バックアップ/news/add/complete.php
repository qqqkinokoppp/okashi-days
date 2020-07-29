<?php 
require_once('../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/NewsManage.php');

// セッションの開始
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

$add_news = $_SESSION['post']['add_news'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お知らせ登録完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お知らせ登録完了</h1>
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
    <p>以下の内容で登録しました。</p>
            <table class="list" height="200">
                <tr>
                    <th>お知らせ見出し</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_news']['news_index'];?>
                    </td>
                </tr>

                <tr>
                    <th>お知らせ内容</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_news']['news_content'];?>
                    </td>
                </tr>

                <tr>
                    <th>掲載期限日</th>
                    <td class="align-left">
                    <?php print $_SESSION['post']['add_news']['expiration_date'];?>
                    </td>
                </tr>

            </table>
            <input type="button" value="戻る" onclick="location.href='../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>