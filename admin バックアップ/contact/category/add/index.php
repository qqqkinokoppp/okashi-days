<?php 
require_once('../../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッションの開始
Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

$token = Safety::getToken();
//前回入力データがあればフォーム初期値用の変数に格納
if(isset($_SESSION['post']['add_contact_category']))
{
    if(isset($_SESSION['post']['add_contact_category']['contact_category']))
    {
        $category_name = $_SESSION['post']['add_contact_category']['contact_category'];
    }    
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お問い合わせカテゴリ登録</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お問い合わせカテゴリ登録</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../login/logout.php'">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <?php if(!empty($_SESSION['error']['add_contact_category'])):?>
        <p class="error">
            <?= $_SESSION['error']['add_contact_category'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
            <table class="list">
                <tr>
                    <th>カテゴリ名</th>
                    <td class="align-left">
                        <?php if(isset($category_name)):?>
                        <input type="text" name="contact_category" id="contact_category" class="contact_category" value="<?= $category_name?>">
                        <?php else:?>
                        <input type="text" name="contact_category" id="contact_category" class="contact_category" value="">
                        <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken()?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>