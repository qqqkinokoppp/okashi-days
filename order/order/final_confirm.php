<?php
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Order.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');


// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    // var_dump($user);
    // exit;
}
else
{
    header('Location: ../../member/login/');
    exit;
}

// var_dump($user);
// exit;

$db_order = new Order();
$delivery_charge = $db_order ->getDeliveryCharge($user['id']);
$date = date('Y-m-d');
$tax_rate = $db_order ->getTaxrate($date);
// var_dump($delivery_charge);
// var_dump($tax_rate);

    
if(isset($_SESSION['cart']))
{
	$cart_items = $_SESSION['cart'];
}
// var_dump($cart_items);

//商品詳細データの取得
$db_item_manage = new ItemManage();
$details = array();
$a = 0;

if(isset($cart_items))
{
	foreach($cart_items as $id => $quantity)
	{
		// 配列の最後尾へ追加していく
		$details[] = $db_item_manage ->getDetail($id);
	}
}

// 小計計算用の変数用意
$subtotal = 0;
foreach($details as $detail)
{
	$subtotal += $detail['unit_price'] * $cart_items[$detail['id']];
}
//　消費税、送料、合計を変数に格納 
$tax = ceil($subtotal*$tax_rate[0]['tax_rate']);
$delivery = $delivery_charge['delivery_charge'];
$total = $subtotal + $tax + $delivery;

// 注文登録用のセッション変数
$_SESSION['order']['tax_rate_id'] = $tax_rate[0]['id'];
$_SESSION['order']['delivery_charge_id'] = $delivery_charge['id'];
$_SESSION['order']['delivery_charge'] = $delivery_charge['delivery_charge'];
$_SESSION['order']['total'] = $total;

// var_dump($_SESSION['cart']);

// 注文詳細登録用のセッション変数
$_SESSION['order_detail'] = array();
$order_detail = $_SESSION['order_detail'];
$x = 0;
foreach($_SESSION['cart'] as $id => $quantity)
{
	$order_detail[] = $db_item_manage ->getDetail($id);
	$order_detail[$x]['quantity'] = $quantity;
	$order_detail[$x]['subtotal'] = $quantity * $order_detail[$x]['unit_price'];
	$x++;
}

$_SESSION['order_detail'] = $order_detail;

// var_dump($_SESSION['order']);
// var_dump($_SESSION['order_detail']);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>購入ページ3 | okashi days.</title>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../../"><img src="../../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user) === true):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['first_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="../../">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="./cart_content.php">カート</a></li>
				<li><a href="../../item/category/">商品カテゴリ一覧</a></li>
				<!-- <li><a href="access.html">アクセス</a></li> -->
				<li><a href="../../item/list.php">商品一覧</a></li>
				<!-- <li><a href="contact.html">お問い合わせ</a></li> -->
				<?php if(!isset($user)):?>
				<li><a href="../../member/registration/">新規会員登録</a></li>
				<li><a href="../../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../../member/">会員ページ</a></li>
				<li><a href="../../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
		<h2>購入ステップ3　最終確認</h2>
		<div class="menu-block">
			<?php foreach($details as $detail):?>
			<div class="menu-item">
				<div class="menu-photo">
					<img src="../../admin/item/detail/img/<?= $detail['item_image'];?>" alt="" width="25%" height="auto">
				</div>
				<div class="menu-text">
					<h3><?= $detail['item_name']; ?></h3>
                    <p>&yen;<?= $detail['unit_price']; ?></p>
                    <p><?= $cart_items[$detail['id']];?>個</p>
				</div>
			</div>
			<?php endforeach; ?>		
        </div>

        <h2>小計</h2>

        <p><?= $subtotal;?> 円(税抜)</p>

        <h2>合計</h2>
        <p>小計：<?= $subtotal;?> 円</p>
        <p>消費税：<?= $tax;?> 円</p>
        <p>送料：<?= $delivery;?> 円</p>
        <h4>合計：<?= $total;?>円</h4>

        <?php
        ?>

        <form action="./process.php" method="post">
		<input type="submit" value="購入" class="btn-cart">
		<br>
        <input type="button" value="戻る" onclick="history.back()">
        </form>
    </main>

	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
	<p>&copy;Copyright Okashi days. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>

