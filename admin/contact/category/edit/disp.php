<?php
require_once("../../../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ContactManage.php');


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

$db = new ContactManage();

//お問い合わせカテゴリの取得
$edit_categories = $db ->getContactCategoryAll();

//foreach用カウンターの初期化
$i = 0;

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お問い合わせカテゴリ修正</title>
<link rel="stylesheet" href="../../../css/normalize.css">
<link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
<div class="container">
    <header>
        <div class="title">
            <h1>お問い合わせカテゴリ修正</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <table class="admin" width="300">
            <tr>
                <th colspan="2">カテゴリ名</th>
            </tr>
            <?php foreach($edit_categories as $edit_category):?>
            <?php if($i%2 === 0):?>
            <tr class="even">
            <?php else:?>
            <tr class="odd">
            <?php endif;?>

                <td class="align-left">
                    <?php
                    print $edit_category['contact_category'];
                    ?>
                </td>
                <td>
                    <form action="index.php" method="post">
                    <!--選択した商品カテゴリのIDを渡す-->
                        <input type="hidden" name="contact_category_id" value="<?= $edit_category['id'];?>">
                        <input type="submit" value="修正">
                    </form>
                </td>
                <?php ?>
            </tr>
            <?php $i++;?>
            <?php endforeach;?>
        </table>
        <input type="button" value="戻る" onclick="location.href='../../../';">

    </main>

    <footer>

    </footer>
</div>
</body>
</html>