<?php 
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
// セッション開始
Session::sessionStart();

//ワンタイムトークンの確認
if(!Safety::checkToken($_POST['token']))
{
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

//サニタイズ
$post = Common::sanitize($_POST);
$_SESSION['post']['add_member'] = $post;
// var_dump($post);
// exit;

$_SESSION['error']['add_member'] = '';

//ログインユーザー名が入力されていなかったら
if($post['user_name'] === '')
{
    $_SESSION['error']['add_member'] = 'ログインユーザー名を入力してください。';
    print '通った1';
    exit;
    header('Location:./index.php');
    exit;
}

//パスワードが入力されていなかったら
if(empty($post['password']))
{
    $_SESSION['error']['add_member'] = 'パスワードを入力してください。';
    print '通った2';
    exit;
    header('Location:./index.php');
    exit;
}

//確認用パスワードが入力されていなかったら
if(empty($post['password2']))
{
    $_SESSION['error']['add_member'] = '確認用パスワードを入力してください。';
    print '通った3';
    exit;
    header('Location:./index.php');
    exit;
}

//姓が入力されていなかったら
if(empty($post['last_name']))
{
    $_SESSION['error']['add_member'] = '姓を入力してください。';
    print '通った4';
    exit;
    header('Location:./index.php');
    exit;
}

//名が入力されていなかったら
if(empty($post['first_name']))
{
    $_SESSION['error']['add_member'] = '名を入力してください。';
    print '通った5';
    exit;
    header('Location:./index.php');
    exit;
}

//姓カナが入力されていなかったら
if(empty($post['last_name_kana']))
{
    $_SESSION['error']['add_member'] = '姓カナを入力してください。';
    print '通った6';
    exit;
    header('Location:./index.php');
    exit;
}

//名カナが入力されていなかったら
if(empty($post['first_name_kana']))
{
    $_SESSION['error']['add_member'] = '名カナを入力してください。';
    print '通った7';
    exit;
    header('Location:./index.php');
    exit;
}

//生年月日が入力されていなかったら
if(empty($post['birthday']))
{
    $_SESSION['error']['add_member'] = '生年月日を入力してください。';
    print '通った8';
    exit;
    header('Location:./index.php');
    exit;
}

//性別が入力されていなかったら
if(!isset($post['gender']))
{
    $_SESSION['error']['add_member'] = '性別を入力してください。';
    print '通った9';
    exit;
    header('Location:./index.php');
    exit;
}

//郵便番号が入力されていなかったら
if(empty($post['postal_code1'])||empty($post['postal_code2']))
{
    $_SESSION['error']['add_member'] = '郵便番号を入力してください。';
    print '通った10';
    exit;
    header('Location:./index.php');
    exit;
}

//住所1が入力されていなかったら
if(empty($post['address1']))
{
    $_SESSION['error']['add_member'] = '住所1（市区町村）を入力してください。';
    print '通った11';
    exit;
    header('Location:./index.php');
    exit;
}

//電話番号が入力されていなかったら
if(empty($post['phone_number']))
{
    $_SESSION['error']['add_member'] = '電話番号を入力してください。';
    print '通った12';
    exit;
    header('Location:./index.php');
    exit;
}


//メールアドレスが入力されていなかったら
if(empty($post['email']))
{
    $_SESSION['error']['add_member'] = 'メールアドレスを入力してください。';
    print '通った13';
    exit;
    header('Location:./index.php');
    exit;
}

//パスワードが一致するかどうかの確認
if(!($post['password'] === $post['password2']))
{
    $_SESSION['error']['add_member'] = 'パスワードが一致しません。';
    print '通った14';
    exit;
    header('Location:./index.php');
    exit;
}

//パスワードのバリデーション
if(((preg_match('/^[a-zA-Z0-9]+$/',$post['password'])) === 0)||(preg_match('/^[a-zA-Z0-9]+$/',$post['password2'])) === 0)
{
    $_SESSION['error']['add_member'] = 'パスワードは半角英数で入力してください。';
    print '通った15';
    exit;
    header('Location:./index.php');
    exit;
}

//ログインユーザー名のバリデーション
if(preg_match('/^[a-zA-Z0-9]+$/', $post['user_name']) === 0)
{
    $_SESSION['error']['add_member'] = 'ログインユーザー名は半角英数で入力してください。';
    header('Location:./index.php');
    exit;
}

//姓カナ、名カナのバリデーション
if(preg_match( '/[ァ-ヶ]+/', $post['last_name_kana']) === 0||preg_match( '/[ァ-ヶ]+/', $post['first_name_kana']) === 0)
{
    $_SESSION['error']['add_member'] = 'カナは全角カタカナで入力してください。';
    header('Location:./index.php');
    exit;
}

//電話番号のバリデーション
if(preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $post['phone_number']) === 0)
{
    $_SESSION['error']['add_member'] = '電話番号を正しく入力してください。';
    header('Location:./index.php');
    exit;
}

// 生年月日のバリデーション
if(strtotime($post['birthday']) === false)
{
    $_SESSION['error']['add_member'] = '生年月日を正しく入力してください。';
    header('Location:./index.php');
    exit;
}

//メールアドレスのバリデーション
if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false)
{
    $_SESSION['error']['add_member'] = 'メールアドレスを正しく入力してください。';
    header('Location:./index.php');
    exit;
}

$_SESSION['post']['add_member'] = $post;
$_SESSION['post']['add_member']['postal_code'] =$post['postal_code1'].$post['postal_code2']; 

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員登録確認</title>
<link rel="stylesheet" href="/okashi_days/member/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/member/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>会員登録確認</h1>
        </div>
    </header>

    <main>
    <p>以下の内容で登録します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?= $post['user_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名(フリガナ)</th>
                    <td class="align-left">
                        <?= $post['last_name_kana'].' '.$post['first_name_kana'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名</th>
                    <td class="align-left">
                        <?= $post['last_name'].' '.$post['first_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>生年月日</th>
                    <td class="align-left">
                        <?= $post['birthday'];?>
                    </td>
                </tr>

                <tr>
                    <th>性別</th>
                    <td class="align-left">
                        <?php 
                        if($post['gender'] === '0')
                        {
                            print '男';
                        }
                        if($post['gender'] === '1')
                        {
                            print '女';
                        }
                        if($post['gender'] === '2')
                        {
                            print '回答しない';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?= $post['postal_code1'].'-'.$post['postal_code2'];?>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <?= $post['prefecture'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村・町名）</th>
                    <td class="align-left">
                    <?= $post['address1'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地・建物名）</th>
                    <td class="align-left">
                    <?= $post['address2'];?>
                    </td>
                </tr>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?= $post['phone_number'];?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?= $post['email'];?>
                    </td>
                </tr>

            </table>
            <input type="submit" value="登録">
            
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>