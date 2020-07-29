<?php 
require_once('../../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');

//セッション開始
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

// $category_name = $_SESSION['edit_category_after']['item_category_name'];
// if($_SESSION['edit_category_after']['item_category_image'] === '')
// {
//     $category_img = $_SESSION['edit_category_before']['item_category_image'];
// }
// else
// {
// $category_img = $_SESSION['edit_category_after']['item_category_image'];
// }

// //使い終わったセッションの破棄
// unset($_SESSION['item_category']);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>エラー</title>
<link rel="stylesheet" href="../../../css/normalize.css">
<link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>エラー</h1>
        </div>
        <div class="login_info">
            <ul>
                <li></li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <p class="error">
            登録済みの商品があるためカテゴリ削除できません。
        </p>
        <form>
            <input type="button" value="戻る" onclick="location.href='./disp.php';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>