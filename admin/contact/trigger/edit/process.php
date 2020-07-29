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
if(!isset($_SESSION['admin_user']))
{
    header('Location: ../../login/');
    exit;
}
else
{
    $user = $_SESSION['admin_user'];
}

// var_dump($_SESSION['post']);
// exit;

// $edit_category = $_SESSION['edit_category_after'];

// var_dump($_SESSION['edit_category_after']);
// exit;

//サニタイズ
$post = Common::sanitize($_POST);

// 入力された情報を変数に格納
$edit_trigger = $_SESSION['post']['edit_contact_trigger'];
//修正するカテゴリのIDを変数に格納
$id = $_SESSION['id']['edit_contact_trigger'];

//商品管理インスタンス生成、カテゴリ修正メソッドの呼び出し
try
{
    $db = new ContactManage();

    $category = $db ->editTrigger($edit_trigger, $id);
        
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    header('Location:../../../error/');
    exit;
    
}

?>