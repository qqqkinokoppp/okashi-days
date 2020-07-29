<?php 
//設定ファイルの読み込み
require_once('../../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ContactManage.php');

//セッションの開始
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


//ワンタイムトークンの取得
$token = Safety::getToken();

//ログインしているユーザーの情報を変数に格納
$user = $_SESSION['admin_user'];

//サニタイズ
$post = Common::sanitize($_POST);

//修正したいカテゴリのIDをセッションに保存
$_SESSION['id']['delete_contact_category'] = $post['contact_category_id'];


//お問い合わせ管理のインスタンス生成
$db = new ContactManage();

// 登録されているお問い合わせのカテゴリIDに$post['contact_category_id']が1つでもあれば、エラー画面
$category_count = $db ->countContactCategory($_SESSION['id']['delete_contact_category']);
var_dump($_SESSION['id']['delete_contact_category']);
var_dump($category_count);
if($category_count['COUNT(*)'] >= 1)
{
    header('Location: ./error.php');
    exit;
}

//POSTされてきた問い合わせIDに該当する情報をDBから取得
$category = $db ->getContactCategory($_SESSION['id']['delete_contact_category']);
$_SESSION['delete_category'] = $category;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お問い合わせカテゴリ削除</title>
<link rel="stylesheet" href="../../../css/normalize.css">
<link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お問い合わせカテゴリ削除</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下のお問い合わせカテゴリを削除します。</p>

        <form action="process.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>お問い合わせカテゴリ名</th>
                    <td class="align-left">
                        <?= $category['contact_category'];?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="削除">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>