<?php
// 設定クラスの読み込み
require_once("../../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
// セッションスタート
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

$deleteuser = $_SESSION['deleteuser']['id'];

//修正するユーザーのIDを変数に格納
$id = $_SESSION['deleteuser']['id'];

$db = new Admin();
try
{
    $admin = $db ->deleteAdmin($id);
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    print '<pre>';
    var_dump($e);
    print '</pre>';
    header('Location:../../error/');
    exit;
}

?>