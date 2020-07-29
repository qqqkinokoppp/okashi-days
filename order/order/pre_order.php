<?php
require_once("../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');

// セッションスタート
Session::sessionStart();

// ログインしていたらそのまま購入ページへ
if(isset($_SESSION['user']))
{
    header('Location: ./cart_content.php');
    exit;
}
else
{
    $_SESSION['url'] = '../../order/order/cart_content.php';
    header('Location: ../../member/login/');
    exit;
}

?>