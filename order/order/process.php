<?php
require_once("../../classes/Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Order.php');

// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    // var_dump($user);
    // exit;
}
else
{
    header('Location: ../../member/login/');
    exit;
}

$order = new Order();
try
{
    // トランザクション開始
    $order ->begin();
    
    // 注文登録
    $order ->orderRegistration($_SESSION['order']);
    
    // 最新の注文IDを取得
    $order_id = $order ->getLastOrder();
    
    // 注文詳細登録
    foreach($_SESSION['order_detail'] as $detail)
    {
        $order ->orderDetail($detail, $order_id['id']);
    }

    // コミット
    $order ->commit();

    // セッションの破棄
    $_SESSION['cart'] = array();
    $_SESSION['order'] = array();
    $_SESSION['order_detail'] = array();
    $_SESSION['cartin'] = array();

    // サンクスページにリダイレクト
    header('Location: ./thanks.php');
    exit;
}
catch(Exception $e)
{
    // 例外発生時はロールバック
    $order ->rollBack();
    // print '<pre>';
    // var_dump($e);
    // print '</pre>';
    exit;
}
?>