<?php 
require_once('../../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッションの開始
Session::sessionStart();
if(!isset($_SESSION['admin_user']))
{
    header('Location: ../login/');
    exit;
}
else
{
    $user = $_SESSION['admin_user'];
}

//前回入力データがあればフォーム初期値用の変数に格納
if(isset($_SESSION['post']['add_admin']))
{
    if(isset($_SESSION['post']['add_admin']['user_name']))
    {
        $user_name = $_SESSION['post']['add_admin']['user_name'];
    }
    if(isset($_SESSION['post']['add_admin']['name']))
    {
        $name = $_SESSION['post']['add_admin']['name'];
    }
    if(isset($_SESSION['post']['add_admin']['email']))
    {
        $email = $_SESSION['post']['add_admin']['email'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者登録</title>
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>管理者登録</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <?php if(!empty($_SESSION['error']['add_admin'])):?>
        <p class="error">
            <?= $_SESSION['error']['add_admin'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
            <table class="list">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php if(isset($user_name)):?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="<?= $user_name?>">
                        <?php else:?>
                        <input type="text" name="user_name" id="user_name" class="user_name
                        " value="">
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td class="align-left">
                    <input type="password" name="password" id="password" class="password" value="">
                    </td>
                </tr>
                <tr>
                    <th>確認用パスワード</th>
                    <td class="align-left">
                    <input type="password" name="password2" id="password2" class="password2" value="">
                    </td>
                </tr>
                <tr>
                    <th>管理者氏名</th>
                    <td class="align-left">
                    <?php if(isset($name)):?>
                    <input type="text" name="name" id="name" class="name" value="<?= $name?>">
                    <?php else:?>
                    <input type="text" name="name" id="name" class="name" value="">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?php if(isset($email)):?>
                    <input type="text" name="email" id="email" class="email" value="<?= $email?>">
                    <?php else:?>
                    <input type="text" name="email" id="email" class="email" value="">
                    <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken()?>">
            <input type="submit" value="確認画面へ" onclick="validate()">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>

<script>
    function validate() {
        const pass = document.getElementById('password').value;
        const pass2 = document.getElementById('password2').value;
        var result1 = pass.match(/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z\-]{12,}$/u);
        var result2 = pass.match(/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z\-]{12,}$/u);
        // console.log('通った');
        if (result1 == null || result2 == null) {
            alert('パスワードは半角英数の大文字、小文字、数字を含んた12桁以上で入力してください。');
        }
    }
</script>
</body>
</html>