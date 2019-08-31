<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ItemManage.php');

//セッション開始
Session::sessionStart();
$user = $_SESSION['user'];


// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) 
{
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

$post = Common::MySanitize($_POST);

//セッションにフォームから送られてきたデータを格納
$_SESSION['add_detail'] = $post;

//画像が選択されていれば、セッションと変数に保存
if(isset($_FILES['item_image']))
{
$item_image = $_FILES['item_image'];
$_SESSION['add_detail']['item_image'] = $_FILES['item_image'];
}

// print '<pre>';
// var_dump($_SESSION['add_detail']);
// print '</pre>';
// exit;

// var_dump($_SESSION['add_detail']);//ここまでOK
// exit;

$_SESSION['error']['add_detail'] = '';

//商品名が入力されていなかったら
if(empty($post['item_name']))
{
    $_SESSION['error']['add_detail'] = '商品名を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品名が100文字超えていれば
if(strlen($post['item_name'])>100)
{
    $_SESSION['error']['add_detail'] = '商品名は100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//商品型番が入力されていなかったら
if(empty($post['item_model_number']))
{
    $_SESSION['error']['add_detail'] = '商品型番を選択してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品型番が20桁超えていれば
if(strlen($post['item_model_number'])>20)
{
    $_SESSION['error']['add_detail'] = '商品型番は20桁以内です。。';
    header('Location:./index.php');
    exit;   
}

//商品カテゴリが選択されていなかったら
if(empty($post['item_category_id']))
{
    $_SESSION['error']['add_detail'] = '商品カテゴリを選択してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品説明が入力されていなかったら
if(empty($post['item_description']))
{
    $_SESSION['error']['add_detail'] = '商品説明を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品説明が100文字超えていれば
if(strlen($post['item_description'])>100)
{
    $_SESSION['error']['add_detail'] = '商品説明は100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//商品詳細が入力されていなかったら
if(empty($post['item_detail']))
{
    $_SESSION['error']['add_detail'] = '商品詳細を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品詳細が500文字超えていれば
if(strlen($post['item_detail'])>500)
{
    $_SESSION['error']['add_detail'] = '商品説明は100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//アレルギー品目が選択されていなかったら
if(empty($post['allergy_item']))
{
    $_SESSION['error']['add_detail'] = 'アレルギーを入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//単価が入力されていなかったら
if(empty($post['unit_price']))
{
    $_SESSION['error']['add_detail'] = '商品単価を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//画像サイズが大きすぎたら
if($_SESSION['add_detail']['item_image']['size']>0)
{
    if($_SESSION['add_detail']['item_image']['size']>1000000)
    {
        $_SESSION['error']['add_detail'] = '画像サイズが大きすぎます。';
        header('Location:./index.php');
        exit;
    }
    else
    {
        //ファイルサイズがOKなら、画像ファイルを移動させる
        move_uploaded_file($_SESSION['add_detail']['item_image']['tmp_name'], '../img/'.$_SESSION['add_detail']['item_image']['name']);
    }
}

//カテゴリ、アレルギー表示のためのDB接続
$db = new ItemManage();

//カテゴリ取得
$category = $db ->getCategory($post['item_category_id']);

//アレルギー取得
// var_dump($post['allergy']);
// exit;
$allergies = array();//foreachのための配列変数準備
foreach($post['allergy_item'] as $value)
{
$allergies += array($value => $db ->getAllergy($value));
}
// print '<pre>';
// var_dump($allergies);//一次元目にはPOSTされてきた数字、2次元目にidとallergy_itemの連想配列
// print '</pre>';
// exit;

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品詳細登録確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品詳細登録確認</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の内容で登録します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>商品名</th>
                    <td class="align-left">
                        <?php print $post['item_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品カテゴリ名</th>
                    <td class="align-left">
                        <?php print $category['item_category_name'];;?>
                    </td>
                </tr>
                <tr>
                    <th>商品型番</th>
                    <td class="align-left">
                        <?php print $post['item_model_number'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品説明</th>
                    <td class="align-left">
                        <?php print $post['item_description'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品詳細</th>
                    <td class="align-left">
                        <?php print $post['item_detail'];?>
                    </td>
                </tr>
                <tr>
                    <th>アレルギー品目</th>
                    <td class="align-left">
                        <?php 
                        foreach($allergies as $allergy)
                        {
                            print $allergy['allergy_item'].' ';
                        }
                        ?>
                    </td>
                </tr>
            
                <tr>
                    <th>単価</th>
                    <td class="align-left">
                        <?php print $post['unit_price'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品画像画像</th>
                    <td class="align-left">
                        <img src="../img/<?php print $_SESSION['add_detail']['item_image']['name'];?>">
                    </td>
                </tr>
                <tr>
                    <th>おすすめ</th>
                    <td class="align-left">
                        <?php if($post['is_recommend'] === "1")
                        {
                            print '〇';
                        }
                        else
                        {
                            print '×';
                        }?>
                    </td>
                </tr>

            </table>
            <input type="hidden" name="category_name" value="<?php print $post['category_name'];?>">
            <input type="hidden" name="category_img" value="<?php print $category_img['name'];?>">
            <input type="submit" value="登録">
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>