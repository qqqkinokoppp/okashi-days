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
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}


//ワンタイムトークンの取得
$token = Safety::getToken();

//サニタイズ
$post = Common::sanitize($_POST);

//修正したいきっかけのIDをセッションに保存
if(isset($post['trigger_id']))
{
    $_SESSION['id']['delete_trigger'] = $post['trigger_id'];
}

//お問い合わせ管理のインスタンス生成
$db = new ContactManage();

// 登録されているお問い合わせのきっかけIDに$post['contact_category_id']が1つでもあれば、エラー画面
$trigger_count = $db ->countTrigger($_SESSION['id']['delete_trigger']);

if($trigger_count['COUNT(*)'] >= 1)
{
    header('Location: ./error.php');
    exit;
}


//POSTされてきたきっかけIDに該当する情報をDBから取得
$trigger = $db ->getTrigger($_SESSION['id']['delete_trigger']);
// $_SESSION['delete_category'] = $category;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>サイトを知ったきっかけ削除</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>サイトを知ったきっかけ削除</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の項目を削除します。</p>

        <form action="process.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>サイトを知ったきっかけ</th>
                    <td class="align-left">
                        <?php print $trigger['contact_trigger'];?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?php print $token;?>">
            <input type="submit" value="削除">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>