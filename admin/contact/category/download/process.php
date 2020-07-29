<?php
//設定ファイルの読み込み
require_once('../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ContactManage.php');

//セッションの開始
Session::sessionStart();

// var_dump($_SESSION['token']);
// var_dump($_POST['token']);
// exit;
if(!isset($_SESSION['admin_user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['admin_user'];
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
try
{
    $db = new ContactManage();
    $contacts = $db ->getContactDate($year, $month, $day);

    // var_dump($contacts);
    // exit;
    // var_dump($orders);
    // ファイルを書き込み専用で開く

    $contact_index = array(
        '0' => array(
        'contact_id' => 'お問い合わせID',
        'contact_datetime' => 'お問い合わせ日時',
        'name' => 'お名前',
        'postal_code' => '郵便番号',
        'prefecture' => '都道府県',
        'address1' => '住所1',
        'address2' =>  '住所2',
        'email' =>  'メールアドレス',
        'phone_number' =>  '電話番号',
        'contact_trigger' =>  'サイトを知ったきっかけ',
        'contact_category' =>  'お問い合わせカテゴリ',
        'contact_content' =>  'お問い合わせ内容'
        )
    ); 

    $contacts = array_merge($contact_index, $contacts);

    $file = fopen("C:/contact/contact-".$post['download'].".csv", 'w');

    $contacts = mb_convert_encoding($contacts, 'SJIS', 'UTF-8');
    foreach($contacts as $contact)
    {
        fputcsv($file, $contact);
    }

    header('Content-Disposition: attachment; filename="contact-'.$post['download'].'.csv"');
    header('Content-Type: application/csv');

    readfile("C:/contact/contact-".$post['download'].".csv");
}
catch(Exception $e)
{
    var_dump($e);
    exit;

}
// $csv='受注ID,受注日時,会員姓,会員名,会員姓カナ,会員名カナ,郵便番号,都道府県,住所1,住所2,電話番号,メールアドレス,送料,合計金額,商品名,数量,商品ID,商品名,価格,数量,小計';
// $csv.="\n";
// print '<pre>';
// var_dump($order);
// print '</pre>';
?>