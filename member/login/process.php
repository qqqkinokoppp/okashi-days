<?php
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();

// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) 
{
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/');
    exit;
}
var_dump($_SESSION['url']);
// exit;

//サニタイズ
$post = Common::sanitize($_POST);
$user_name = $post['user_name'];
$password = $post['password'];

try
{
    $db = new Member();
    $user = $db ->loginMember($user_name, $password);
    if(empty($user))
    {
        $_SESSION['error']['member_login'] = "ユーザー名またはパスワードが違います。";
        // exit;
        header('Location: ./');
        exit;
    }
    else
    {
        // ユーザーの情報が取得できたとき
        // ユーザーの情報をセッション変数に保存
        $_SESSION['user'] = $user;
        // セッション変数に保存されているエラーメッセージをクリア
        $_SESSION['error']['member_login'] = "";
        unset($_SESSION['error']['member_login']);
        if(!empty($_SESSION['url']))
        {
            // print '通った1';
            header("Location:".$_SESSION['url']);
            exit;
        }
        else
        {
            // print '通った2';
            header("Location:../../");
            exit;
        }
        // print '通った3';
        // exit;
        // header('Location: ../');
        // exit;
    }
}   
catch(Exception $e)
{
    // print '<pre>';
    // var_dump($e);
    // print '</pre>';
    header('Location: ../../error/');
    exit;
}
