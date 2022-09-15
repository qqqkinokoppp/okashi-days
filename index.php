<?php
require_once("/Applications/MAMP/htdocs/okashi-days/classes/Config.php");
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

<title>okashi days.</title>
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
</head>
<body>
	<script src="https://unpkg.com/vue"></script>
    <div class="logo_anime">
		<svg version="1.1" id="logo_anime" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		viewBox="0 0 585.3 121.2" style="enable-background:new 0 0 585.3 121.2;" xml:space="preserve">
		<style type="text/css">
		.hana1{fill:#E62767;}
		.tenn{fill:#E84680;}
		.hana2{fill:#EB6F99;}
		</style>
		<g id="hana1" class="visible">
			<path class="hana1" d="M36.7,34.3C79.3-8.3-6-8.3,36.7,34.3C-6-8.3-6,77,36.7,34.3C-6,77,79.3,77,36.7,34.3
				C79.3,77,79.3-8.3,36.7,34.3z"/>
		</g>
		<g id="okashi_days">
			<path d="M96.9,66c0,18.9-14.7,27.1-27.1,27.1c-15,0-25.9-11-25.9-25.9c0-16.8,12.6-27,26.7-27C86.7,40.2,96.9,51.6,96.9,66z
					M49,66.9c0,14.1,10.2,22,21.1,22c11.1,0,21.6-8.1,21.6-22.6c0-9.6-6.4-21.9-21.2-21.9C56.2,44.4,49,55.1,49,66.9z"/>
			<path d="M115.8,65.7h0.2c1.4-1.6,3.8-4.1,5.6-5.8l19.6-18.5h6.5l-22.5,20.8l25.7,29.6h-6.4l-23-26.7l-5.8,5.6v21.1h-5.1V16.7h5.1
				V65.7z"/>
			<path d="M189.3,91.8l-0.8-7.8h-0.2c-2.6,3.9-9,9-18.3,9c-11.4,0-16.1-7.8-16.1-13.9c0-11.4,10.6-18.9,34.1-18.6v-1.2
				c0-3.8-0.8-15.1-14.3-15c-5,0-10.3,1.3-14.5,4.2l-1.7-3.7c5.6-3.7,11.8-4.8,16.6-4.8c17.1,0,19,13.2,19,21.2v18.3
				c0,4.1,0.2,8.1,0.8,12.2H189.3z M188,65c-13.3-0.4-28.7,1.7-28.7,13.3c0,7.1,5.1,10.6,11,10.6c9.8,0,15-5.8,17-10.3
				c0.4-1,0.6-2.1,0.6-2.9V65z"/>
			<path d="M208.7,85c3,1.9,7.6,3.8,12.6,3.8c8.8,0,12.7-4.6,12.7-9.8c0-5.9-4-8.7-11.9-11.2c-9.1-2.9-13.6-7.7-13.6-13.6
				c0-7.1,5.7-14,16.6-14c4.9,0,9.2,1.4,12.2,3.4l-2,4.2c-1.7-1.2-5.4-3.3-11.1-3.3c-6.9,0-10.6,4.2-10.6,9c0,5.7,4.3,7.9,11.8,10.4
				c9.2,3.1,13.8,7.1,13.8,14.7c0,8.2-6.7,14.5-18.2,14.5c-5.4,0-10.3-1.5-14.1-3.7L208.7,85z"/>
			<path d="M253.6,16.7h5.1v35h0.2c1.6-3.1,4.3-6.2,7.8-8.2c3.3-2,7.2-3.3,11.3-3.3c4.8,0,19.6,2.1,19.6,22.9v28.8h-5.1V63.3
				c0-9.8-4.2-18.6-15.9-18.6c-8,0-14.7,5.7-17.1,11.9c-0.6,1.6-0.8,3-0.8,5.4v29.9h-5.1V16.7z"/>
			<path d="M315.7,91.8V41.4h5.1v50.4H315.7z"/>
			<path d="M409.2,16.7v63c0,4.1,0.1,8.1,0.4,12.2h-4.7l-0.3-10.5h-0.2c-2.9,6.3-9.9,11.8-20.4,11.8c-14.2,0-24.3-11.3-24.3-25.3
				c-0.1-16.4,11.2-27.6,25.4-27.6c10.5,0,16.5,5.6,18.7,9.7h0.2V16.7H409.2z M404.1,61.7c0-1.5-0.2-3.5-0.6-4.9
				c-2.2-6.8-8.7-12.4-18.2-12.4c-12,0-20.4,9.1-20.4,22.8c0,11.3,6.6,21.7,20.3,21.7c8.6,0,16.2-5.9,18.3-13.9
				c0.4-1.4,0.6-2.7,0.6-4.4V61.7z"/>
			<path d="M458.3,91.8l-0.8-7.8h-0.2c-2.6,3.9-9,9-18.3,9c-11.4,0-16.1-7.8-16.1-13.9c0-11.4,10.6-18.9,34.1-18.6v-1.2
				c0-3.8-0.8-15.1-14.3-15c-5,0-10.3,1.3-14.5,4.2l-1.7-3.7c5.6-3.7,11.8-4.8,16.6-4.8c17.1,0,19,13.2,19,21.2v18.3
				c0,4.1,0.2,8.1,0.8,12.2H458.3z M457,65c-13.3-0.4-28.7,1.7-28.7,13.3c0,7.1,5.1,10.6,11,10.6c9.8,0,15-5.8,17-10.3
				c0.4-1,0.6-2.1,0.6-2.9V65z"/>
			<path d="M477.1,41.4l15,33.7c1.5,3.3,3.1,7.5,4.1,10.6h0.2c1.2-3.1,2.5-6.9,4.2-11l14.1-33.3h5.6l-17.8,40.7
				c-6.9,16-11.4,23.8-18.2,28.7c-4.3,3.1-8.2,4.3-9.2,4.5l-1.4-4.3c2.5-0.7,6.1-2.2,9.2-4.9c2.6-2.2,6.5-6.4,9.7-13.5
				c0.4-0.9,0.6-1.6,0.6-2c0-0.4-0.2-1.2-0.7-2.3l-20.9-46.8H477.1z"/>
			<path d="M528.1,85c3,1.9,7.6,3.8,12.6,3.8c8.8,0,12.7-4.6,12.7-9.8c0-5.9-4-8.7-11.9-11.2c-9.1-2.9-13.6-7.7-13.6-13.6
				c0-7.1,5.7-14,16.6-14c4.9,0,9.2,1.4,12.2,3.4l-2,4.2c-1.7-1.2-5.4-3.3-11.1-3.3c-6.9,0-10.6,4.2-10.6,9c0,5.7,4.3,7.9,11.8,10.4
				c9.2,3.1,13.8,7.1,13.8,14.7c0,8.2-6.7,14.5-18.2,14.5c-5.4,0-10.3-1.5-14.1-3.7L528.1,85z"/>
			<path d="M569.6,88.3c0-2.8,1.9-4.9,4.5-4.9c2.6,0,4.4,2.1,4.4,4.9c0,2.5-1.8,4.8-4.5,4.8C571.4,93.1,569.5,90.8,569.6,88.3z"/>
		</g>
		<rect id="tenn" class="visible" x="313.3" y="21" class="tenn" width="10" height="10"/>
		<g id="hana2" class="visible">
			<path class="hana2" d="M385,66.9C351.6,67.3,384.5,100.2,385,66.9C384.5,100.2,418.4,66.4,385,66.9C418.4,66.4,385.4,33.5,385,66.9
				C385.4,33.5,351.6,67.3,385,66.9z"/>
		</g>
		<polygon class="st2" points="83,-37.3 83,-37.3 83,-37.3 83,-37.3 "/>
		</svg>
	</div>

<div class="top_page" >
<script src="https://unpkg.com/vue"></script>
		<div id="app">
		{{a}}
		</div>
		
		<script>
		new Vue({
		el: "#app",
		data: {
		a: "Hello World",
		},
		})
		</script>
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
					<li><a href="./tenpo/index.php">アクセス</a></li>
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
				<img src="<?= './admin/item/detail/img/'.$a?>">
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
		observer: true,
		observeParents: true,
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
		},

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
			<p>&copy;Copyright Okashi days. All rights reserved.</p>
		</footer>
		<!-- フッター ここまで -->
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- ロゴアニメーションからトップページの切り替え -->
<script>
$(function(){
	setTimeout(function() {
		$('.logo_anime').fadeOut();
	}, 2000);
	setTimeout(function() {
		$('.top_page').css({'visibility':'visible', 'width':'100%','height':'100%'});
		$('.top_page').fadeIn();
	},3000);
})
</script>

<!-- 画像のスライダー -->
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
</body>
</html>