<?php
require_once('../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');

Session::sessionStart();
// if(!isset($_SESSION['user']))
// {
//      header('Location: ./login/index.php');   
// }
// else
// {
//     // var_dump($_SESSION['user']);
//     // exit;
//     $user = $_SESSION['user'];
// }

//トップページでセッションを破棄
unset($_SESSION['error']);
unset($_SESSION['post']);
unset($_SESSION['before']);
unset($_SESSION['id']);
unset($_SESSION['token']);
//var_dump($_SESSION);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>お店へのアクセス | okashi days.</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../index.php"><img src="../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<nav class="nav">
			<ul>
				<li><a href="../">ホーム</a></li>
                <li><a href="../order/cart/">カート</a></li>
                <li><a href="../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="../item/list.php">商品一覧</a></li>
                <li><a href="/akusesu/">アクセス</a></li>
				<?php if(!isset($user)):?>
				<li><a href="../member/registration.php">新規会員登録</a></li>
				<li><a href="../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>

    <main>

    <div id="map" style="height:500px; width: 50%; margin: 2rem auto 0;"></div>
            <!-- jqueryの読み込み -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <!-- js -->
        <script src="https://maps.googleapis.com/maps/api/js?key=Mykey"></script>
        <script type="text/javascript">
            var map = new google.maps.Map(
            document.getElementById("map"),{
            zoom : 15,
            center : new google.maps.LatLng(34.681291, 135.493800),
            mapTypeId : google.maps.MapTypeId.ROADMAP
            }
            );
            var marker = new google.maps.Marker({
            position: new google.maps.LatLng(34.681291, 135.493800),
            map: map,
            draggable : true
            });
            // Check
            function check(){
            var pos = marker.getPosition();
            var lat = pos.lat();
            var lng = pos.lng();
            $("#lat").val(lat);
            $("#lng").val(lng);
            // alert("緯度："+lat+"、経度："+lng);
            }
        </script>

    </main>

    <footer>
    <p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer>
</div>
</body>
</html>