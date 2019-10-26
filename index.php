<?php
require_once("../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/NewsManage.php');

// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
}
// var_dump($user);
// exit;


$_SESSION['url'] = '';
$_SESSION['post'] = array();

// var_dump($_SESSION);
//おすすめ商品データの取得
$db_recommend = new ItemManage();
$recommends = $db_recommend ->getRecommendDetail();

// おすすめ商品の数（for文用）
$recommends_count = $db_recommend ->countRecommend();
//foreach用カウンターの初期化
$i = 0;

$images = scandir('./admin/item/detail/img/');//指定ディレクトリ内にあるファイルとディレクトリの取得　ファイル名、ディレクトリ名が配列が返ってきてる
$img = array();//画像を入れる配列を初期化
//var_dump($images);
foreach($images as $i)
{
    if(is_file("./admin/item/detail/img/$i"))//$images内の要素のうち、ファイルであるもののみ、$imgに入れていく！！覚書　ダブルクォーテーション内の変数は展開される
    {
        $img[] = $i;
    }
}
//var_dump($img);

// お知らせの取得
$news_db = new NewsManage();
// お知らせ取得のため今日の日付を取得
$date = new DateTime();
$today = $date ->format('Y-m-d');
// 掲載期限内のお知らせ取得
$newses = $news_db ->getNewsTop($today);
// var_dump($newses);
// var_dump($user);

// エラーメッセージ初期化
$_SESSION['error'] = array();

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script><!--swiperのライブラリ、スタイルシート読み込み-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.css">
<title>okashi days.</title>
<link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="./index.php"><img src="./images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user) === true):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['first_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="./">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="./order/cart/">カート</a></li>
				<li><a href="./item/category/">商品カテゴリ一覧</a></li>
				<li><a href="./item/list.php">商品一覧</a></li>
				<li><a href="./contact/">お問い合わせ</a></li>
				<?php if(!isset($user)):?>
				<li><a href="./member/registration/">新規会員登録</a></li>
				<li><a href="./member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="./member/">会員ページ</a></li>
				<li><a href="./member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<div class="bg-test">
    <div class="swiper-container" style="background-image:url(../okashi_back.png)">
        <div class="swiper-wrapper">
			<?php foreach($img as $a):?><!--スライドさせる画像をforeachで回す-->
			<?php foreach($recommends as $key => $recommend):?>
			<!-- おすすめ商品の画像をスライド表示させる -->
			<?php if($a === $recommend['item_image']):?>
			<div class="swiper-slide" align="center">
			<a href="./item/detail.php?id=<?= $recommend['id'];?>">
			<img src="<?php print './admin/item/detail/img/'.$a?>">
			</a>
			</div>
			<?php endif;?>
			<?php endforeach;?>
			<?php endforeach;?>
        </div>
        <div class="swiper-pagination"></div><!--ページネーション-->
            <div class="swiper-button-prev"></div><!--右へ左へボタン-->
            <div class="swiper-button-next"></div>
    </div>
</div>
<script>
var mySwiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 3000,
    autoplay: {
    delay: 3000,
    disableOnInteraction: false
    },
    pagination: {
		el: '.swiper-pagination',
		type: 'bullets',
		clickable: true
	},
    navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev'
	}

});
</script>
	<!-- <div class="keyvisual">
		<img src="images/keyvisual.jpg" alt="">
	</div> -->
	<main>
		<h2 id="news">News</h2>
		<?php foreach($newses as $news):?>
		<p class="news-item">
			<b><?= $news['news_index'];?></b>
			<p><?= $news['news_content'];?></p>
		<?php endforeach;?>
	</main>
	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
		<p>&copy;Copyright KUJIRA Cafe. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>