<?php
//設定ファイルの読み込み
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Order.php');

//セッションの開始
Session::sessionStart();

// var_dump($_SESSION['token']);
// var_dump($_POST['token']);
// exit;
if(!isset($_SESSION['user']))
{
    header('Location: ../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) {
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/');
    exit;
}

$post = Common::sanitize($_POST);

// var_dump($post);
$year = mb_substr($post['download'],0,4);
$month = mb_substr($post['download'],5,2);
$day = mb_substr($post['download'],8,2);


// print $year;
// print $month;
// print $day;

// exit;
$db = new Order();
$orders = $db ->getOrderDate($year, $month, $day);

// var_dump($orders);
// ファイルを書き込み専用で開く

$order_index = array(
'0' => array(
'order_id' => '受注ID',
'order_date_time' => '受注日時',
'last_name' => '会員姓',
'first_name' =>  '会員名',
'last_name_kana' =>  '会員姓カナ',
'first_name_kana' =>  '会員名カナ',
'postal_code' =>  '郵便番号',
'prefecture' =>  '都道府県',
'address1' =>  '住所1',
'address2' =>  '住所2',
'phone_number' =>  '電話番号',
'email' =>  'メールアドレス',
'delivery_charge' =>  '送料',
'total' =>  '合計金額' ,
'item_id' =>  '商品ID' ,
'item_name' =>  '商品名' ,
'unit_price' =>  '単価' ,
'quantity' =>  '数量' ,
'subtotal' => '小計'
)
); 

$orders = array_merge($order_index, $orders);

$file = fopen("C:/order/order-".$post['download'].".csv", 'w');

$orders = mb_convert_encoding($orders, 'SJIS', 'UTF-8');
foreach($orders as $order)
{
    fputcsv($file, $order);
}

header('Content-Disposition: attachment; filename="order-'.$post['download'].'.csv"');
header('Content-Type: application/csv');

readfile("C:/order/order-".$post['download'].".csv");
// $csv='受注ID,受注日時,会員姓,会員名,会員姓カナ,会員名カナ,郵便番号,都道府県,住所1,住所2,電話番号,メールアドレス,送料,合計金額,商品名,数量,商品ID,商品名,価格,数量,小計';
// $csv.="\n";
// print '<pre>';
// var_dump($order);
// print '</pre>';
?>