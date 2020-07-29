<?php
// 設定クラスの読み込み
require_once("../../../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ContactManage.php');

// セッションスタート
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


//サニタイズ
$post = Common::sanitize($_POST);

//修正するカテゴリのIDを変数に格納
$id = $_SESSION['id']['delete_trigger'];

//商品管理インスタンス生成、カテゴリ修正メソッドの呼び出し
$db = new ContactManage();
try
{
    $trigger = $db ->deleteTrigger($_SESSION['id']['delete_trigger']);
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    print '<pre>';
    var_dump($e);
    print '</pre>';
    header('Location:../../../error/');
    exit;
}

?>