<?php 
require_once('../../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

//セッション開始
Session::sessionStart();
if(!isset($_SESSION['admin_user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['admin_user'];
}

$post = Common::sanitize($_POST);

$categoryName = $_SESSION['post']['add_contact_trigger']['contact_trigger'];


// var_dump($_SESSION['post']);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>サイトを知ったきっかけ登録完了</title>
<link rel="stylesheet" href="../../../css/normalize.css">
<link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>サイトを知ったきっかけ登録完了</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の内容で登録しました。</p>
            <table class="list" height="200">
                <tr>
                    <th>サイトを知ったきっかけ</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_contact_trigger']['contact_trigger'];?>
                    </td>
                </tr>
            </table>
            <input type="button" value="戻る" onclick="location.href='../../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>