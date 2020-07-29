<?php
// 郵便番号をGETして、それに該当する住所をDBから取得、JSONに変換
require_once('../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Address.php');


// サニタイズ
$postal_code = htmlspecialchars($_POST['postal_code']);

// 半角数字がどうか、7桁かどうかチェック
if((preg_match("/^[0-9]+$/", $postal_code) === 0) || (strlen($postal_code) !== 7))
{
    print '';
}
else
{
    $db = new Address();
    $address = $db ->getAddress($postal_code);

    if($address['address2'] === '以下に掲載がない場合')
    {
        $address['address2'] = '';
    }

    //jsonに変換,
    //日本語をそのままの形式で扱い：JSON_UNESCAPED_UNICODE
    $return_address = json_encode($address, JSON_UNESCAPED_UNICODE);

    header('content-type: application/json; charset=utf-8');
    print $return_address;
}
?>