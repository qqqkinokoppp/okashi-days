<?php
// 設定クラスの読み込み
require_once("../../../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');

// セッションスタート
Session::sessionStart();
//サニタイズ
$post = Common::sanitize($_POST);

//アレルギー品目をJSON形式に変換し、セッションのアレルギー項目へ上書き
$allergy = json_encode($_SESSION['add_detail']['allergy_item']);
$_SESSION['add_detail']['allergy_item'] = $allergy;

//DB登録用の変数に保存
$item_detail = $_SESSION['add_detail'];

// print '<pre>';
// var_dump($_SESSION['add_detail']);
// print '</pre>';
// exit;

$db = new ItemManage();
try
{
    $category = $db ->addItemDetail($item_detail);
    header('Location:./complete.php');
}
catch(Exception $e)
{
    print '<pre>';
    var_dump($e);
    print '</pre>';
    //header('Location:../../error/');
}

?>