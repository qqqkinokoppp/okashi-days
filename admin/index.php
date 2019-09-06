<?php
require_once('../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');

Session::sessionStart();
if(!isset($_SESSION['user']))
{
     header('Location: ./login/index.php');   
}
else
{
    $user = $_SESSION['user'];
}

$_SESSION['error']['adminadd'] = '';

//トップページでセッションを破棄
unset($_SESSION['add_detail']);
unset($_SESSION['error']['edit_detail']);
unset($_SESSION['error']['add_detail']);
unset($_SESSION['edit_detail_after']);
unset($_SESSION['edit_detail_before']);
unset($_SESSION['delete_category']);
unset($_SESSION['delete_detail_id']);
unset($_SESSION['edit_detail_id']);
unset($_SESSION['add_detail']);
unset($_SESSION['adminadd']);


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者トップページ</title>
<link rel="stylesheet" href="./css/normalize.css">
<link rel="stylesheet" href="./css/main.css">
</head>
<body>
<div class="container">
    <header>
        <div class="title">
            <h1>管理者メニュー一覧</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='./login/logout.php'">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>

        <table class="admin">
            <tr>
                <th colspan="2">管理者管理</th>
            </tr>
            <tr class="even">
                <td class="align-left" width="300">
                    管理者管理
                </td>
                <td>
                    <form action="admin/add/" method="post">                       
                        <input type="submit" value="管理者登録">
                    </form>
                    <form action="admin/edit/disp.php" method="post"><!--管理者修正ページ（管理者一覧表示される）へ-->                        
                        <input type="submit" value="管理者情報修正">
                    </form>
                    <form action="admin/delete/disp.php" method="post"><!--管理者削除ページ（管理者一覧表示される）へ-->                        
                        <input type="submit" value="管理者削除">
                    </form>
                </td>
            </tr>
        </table>

        <table class="item">
            <tr>
                <th colspan="2">商品管理</th>
            </tr>
            <tr class="even">
                <td class="align-left" width="300">
                    商品詳細管理
                </td>
                <td>
                    <form action="item/detail/add/" method="post">                       
                        <input type="submit" value="商品詳細登録">
                    </form>
                    <form action="item/detail/edit/disp.php" method="post">                        
                        <input type="submit" value="商品詳細修正">
                    </form>
                    <form action="item/detail/delete/disp.php" method="post">                       
                        <input type="submit" value="商品詳細削除">
                    </form>
                </td>
            </tr>

            <tr class="even">
                <td class="align-left" width="300">
                    商品カテゴリ管理
                </td>
                <td>
                    <form action="item/category/add/" method="post">
                        <input type="submit" value="商品カテゴリ登録">
                    </form>
                    <form action="item/category/edit/disp.php" method="post">
                        <input type="submit" value="商品カテゴリ修正">
                    </form>
                    <form action="item/category/delete/disp.php" method="post">
                        <input type="submit" value="商品カテゴリ削除">
                    </form>
                </td>
            </tr>
        </table>

        <table class="customer">
            <th colspan="2">会員管理</th>
            <tr class="even">
                <td class="align-left" width="300">
                    会員管理
                </td>
                <td>
                    <form action="#" method="post">
                        <input type="submit" value="会員情報修正">
                    </form>
                    <form action="#" method="post">                   
                        <input type="submit" value="購入履歴確認">
                    </form>
                    <form action="delete.html" method="post">
                        <input type="submit" value="退会">
                    </form>
                </td>
            </tr>
            
        </table>

        <table class="news">
                <th colspan="2">お知らせ管理</th>
                <tr class="even">
                    <td class="align-left" width="300">
                        お知らせ管理
                    </td>
                    <td>
                        <form action="#" method="post">                            
                            <input type="submit" value="お知らせ登録">
                        </form>
                        <form action="#" method="post"> 
                            <input type="submit" value="お知らせ修正">
                        </form>
                        <form action="delete.html" method="post">    
                            <input type="submit" value="お知らせ削除">
                        </form>
                    </td>
                </tr>
                
        </table>

        <table class="order">
                <th>受注管理</th>
                <tr class="even">
                    <td>
                        <form action="#" method="post">
                            
                            <input type="submit" value="受注データCSVダウンロード">
                        </form>
                    </td>
                </tr>
                
        </table>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>