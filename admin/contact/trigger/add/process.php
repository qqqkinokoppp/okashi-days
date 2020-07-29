<?php
// 設定クラスの読み込み
require_once("../../../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ContactManage.php');
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
//サニタイズ
$post = Common::sanitize($_POST);

var_dump($_SESSION['post']['add_contact_trigger']);

$db = new ContactManage();
try
{
    $category = $db ->addTrigger($_SESSION['post']['add_contact_trigger']);
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    var_dump($e);
    header('Location:../../../error/');
    exit;
}

?>