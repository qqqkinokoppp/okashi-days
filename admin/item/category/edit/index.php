<?php 
//設定ファイルの読み込み
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ItemManage.php');

//セッションの開始
Session::sessionStart();


//ワンタイムトークンの取得
$token = Safety::getToken();

//ログインしているユーザーの情報を変数に格納
$user = $_SESSION['user'];

//サニタイズ
$post = Common::sanitize($_POST);

//修正したいカテゴリのIDをセッションに保存
if(isset($post['item_category_id']))
{
$_SESSION['edit_category']['id'] = $post['item_category_id'];
}

//商品管理のインスタンス生成
$db = new ItemManage();

//POSTされてきた商品カテゴリIDに該当する情報をDBから取得
$category = $db ->getCategory($_SESSION['edit_category']['id']);
$_SESSION['edit_category_before'] = $category;

//フォーム初期化のための変数に値を格納
$edit_category = $_SESSION['edit_category_before'];

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品カテゴリ修正</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品カテゴリ修正</h1>
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
        <!--エラーメッセージがセットされていたら-->
        <?php if(!empty($_SESSION['error']['edit_category'])):?>
        <p class="error">
            <?php print $_SESSION['error']['edit_category'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>商品カテゴリ名</th>
                    <td class="align-left">
                        <input type="text" name="edit_category_name" id="edit_category_name" class="edit_category_name" value="<?php print $edit_category['item_category_name'];?>">
                    </td>
                </tr>
            
                <tr>
                    <th>カテゴリ画像</th>
                    <td class="align-left">
                    <img src="../img/<?php print $edit_category['item_category_image'];?>">
                    <input type="file" name="edit_category_img" id="edit_category_img" class="edit_category_img" value="<?php print $edit_category['item_category_image'];?>">
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?php print $token;?>">
            <!---->
            <input type="hidden" name="old_category_img_name" value="<?php print $_SESSION['edit_category_before']['item_category_image'];?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>