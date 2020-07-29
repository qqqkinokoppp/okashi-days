<?php 
//設定ファイルの読み込み
require_once('../../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ContactManage.php');

//セッションの開始
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

//ワンタイムトークンの取得
$token = Safety::getToken();


//サニタイズ
$post = Common::sanitize($_POST);

//修正したいきっかけのIDをセッションに保存
if(isset($post['contact_trigger_id']))
{
    $_SESSION['id']['edit_contact_trigger'] = $post['contact_trigger_id'];
}

//商品管理のインスタンス生成
$db = new ContactManage();

// var_dump( $_SESSION['id']['edit_contact_trigger']);
//POSTされてきたきっかけIDに該当する情報をDBから取得
$contact_trigger = $db ->getTrigger($_SESSION['id']['edit_contact_trigger']);
$_SESSION['before']['edit_contact_trigger'] = $contact_trigger;

// var_dump($_SESSION['before']['edit_contact_trigger']);
//フォーム初期化のための変数に値を格納
// $edit_category = $_SESSION['edit_category_before'];

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>サイトを知ったきっかけ修正</title>
<link rel="stylesheet" href="../../../css/normalize.css">
<link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>サイトを知ったきっかけ修正</h1>
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
        <!--エラーメッセージがセットされていたら-->
        <?php if(!empty($_SESSION['error']['edit_contact_trigger'])):?>
        <p class="error">
            <?= $_SESSION['error']['edit_contact_trigger'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
            <table class="list">
                <tr class="align-left">
                    <th class="align-left">サイトを知ったきっかけ</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['post']['edit_contact_trigger']['contact_trigger'])):?>
                        <input type="text" name="edit_contact_trigger" id="edit_contact_trigger" class="edit_contact_trigger" value="<?= $_SESSION['post']['edit_contact_trigger']['contact_trigger'];?>">
                        <?php else:?>
                        <input type="text" name="edit_contact_trigger" id="edit_contact_trigger" class="edit_contact_trigger" value="<?= $_SESSION['before']['edit_contact_trigger']['contact_trigger'];?>">
                        <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>