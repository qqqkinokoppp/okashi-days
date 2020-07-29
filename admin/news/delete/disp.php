<?php
require_once("../../../classes/Config.php");

// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/NewsManage.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
// セッションスタート
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

$db = new NewsManage();
//お知らせデータの取得
$delete_newses = $db ->getNewsAll();
//foreach用カウンターの初期化
$i = 0;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お知らせ削除</title>
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/main.css">
</head>
<body>
<div class="container">
    <header>
        <div class="title">
            <h1>お知らせ削除</h1>
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

        <table class="admin" width="300">
            <tr>
                <th>お知らせ見出し</th>
                <th>お知らせ内容</th>
                <th>掲載期限日</th>
                <th>削除</th>
            </tr>
            <?php foreach($delete_newses as $delete_news):?>
            <?php if($i%2 === 0):?>
            <tr class="even">
            <?php else:?>
            <tr class="odd">
            <?php endif;?>
                <td class="align-left">
                    <?= $delete_news['news_index'];?>
                </td>
                <td class="align-left">
                    <?= $delete_news['news_content'];?>
                </td>
                <td class="align-left">
                    <?= $delete_news['expiration_date'];?>
                </td>
                <td>
                    <form action="index.php" method="post">
                    <!--選択したユーザーのIDを渡す-->
                        <input type="hidden" name="news_id" value="<?php print $delete_news['id'];?>">
                        <input type="submit" value="削除">
                    </form>
                </td>
                <?php ?>
            </tr>
            <?php $i++;?>
            <?php endforeach;?>
        </table>
        <input type="button" value="戻る" onclick="location.href='../../';">

    </main>

    <footer>

    </footer>
</div>
</body>
</html>