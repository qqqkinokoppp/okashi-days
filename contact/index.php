<?php
require_once('../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ContactManage.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Address.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
}


// <!-- 都道府県取得のためのDB接続 -->
$address = new Address();
$prefectures = $address ->getPrefAll();

// お問い合わせカテゴリ、きっかけ取得
$contact = new ContactManage();
$contact_categories = $contact ->getContactCategoryAll();
$contact_triggeres = $contact ->getTriggerAll();

var_dump($contact_categories);
var_dump($contact_triggeres);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script><!--swiperのライブラリ、スタイルシート読み込み-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.css">
<title>okashi days.</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../"><img src="../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user)):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['first_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="../">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="../order/cart/">カート</a></li>
				<li><a href="../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="../item/list.php">商品一覧</a></li>
				<li><a href="./">お問い合わせ</a></li>
				<?php if(!isset($user)):?>
				<li><a href="../member/registration/">新規会員登録</a></li>
				<li><a href="../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
        <h2>お問い合わせ</h2>
        <?php
        if(isset($_SESSION['error']['contact'])):?>
        <p class="error">
            <?php print $_SESSION['error']['contact'];?>
        </p>
        <?php endif;?>
		<form method="post" action="confirm.php">
			<div>
                お名前<br>
                <?php if(!empty($_SESSION['post']['contact']['name'])):?>
                <label><input type="text" name="name" value="<?= $_SESSION['post']['contact']['name']; ?>" >
                <?php else:?>
                <label><input type="text" name="name" value="" >
                <?php endif;?>
			</div>
			<div>
                郵便番号<br>
                <?php if(!empty($_SESSION['post']['contact']['postal_code1']) && !empty($_SESSION['post']['contact']['postal_code2'])):?>
                <input type="text" name="postal_code1" id="postal_code1" class="postal_code1" value="<?= $_SESSION['post']['contact']['postal_code1']?>" style="width:50px;">-
                <input type="text" name="postal_code2" id="postal_code2" class="postal_code2" value="<?= $_SESSION['post']['contact']['postal_code2']?>" style="width:50px;">
                <?php else:?>
                <input type="text" name="postal_code1" id="postal_code1" class="postal_code1" value="" style="width:50px;">-
                <input type="text" name="postal_code2" id="postal_code2" class="postal_code2" value="" style="width:50px;">
                <?php endif;?>
                <input type="button" value="住所検索" id="search"><div id="error"></div>
            </div>
            <div>
                都道府県<br>
                <select name="prefecture_id" id="prefecture_id">
                <option value=""></option>
                <?php foreach($prefectures as $prefecture_select):?>
                <option value="<?= $prefecture_select['id']?>" 
                <?php if(!empty($_SESSION['post']['contact']['prefecture_id'])){
                    if($_SESSION['post']['contact']['prefecture_id'] === $prefecture_select['id'])
                    {
                        print 'selected';
                        }
                    }
                ?>>
                <?= $prefecture_select['prefecture']?>
                </option>
                <?php endforeach;?>
                </select>               
            </div>
            <div>
                住所1（市区町村・町名<br>
                <?php if(!empty($_SESSION['post']['contact']['address1'])):?>
                <input type="text" name="address1" id="address1" class="address1" value="<?= $_SESSION['post']['contact']['address1']?>">
                <?php else:?>
                <input type="text" name="address1" id="address1" class="address1" value="">
                <?php endif;?>
            </div>
            <div>
                住所2（番地・建物名）<br>
                <?php if(!empty($_SESSION['post']['contact']['address2'])):?>
                <input type="text" name="address2" id="address2" class="address2" value="<?= $_SESSION['post']['contact']['address2']?>">
                <?php else:?>
                <input type="text" name="address2" id="address2" class="address2" value="">
                <?php endif;?>
            </div>

                <!-- hiddenで都道府県名もpostする -->
                <?php if(!empty($_SESSION['post']['contact']['prefecture'])):?>
                <input type="hidden" name="prefecture" id="prefecture" class="prefecture" value="<?= $_SESSION['post']['contact']['prefecture'];?>">
                <?php else:?>
                <input type="hidden" name="prefecture" id="prefecture" class="prefecture" value="">
                <?php endif;?>


                <!-- 住所検索 -->
                <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
                <script>
                $(function(){
                    $('#search').click(function(){
                        // console.log('a');//chromeディベロッパーツールのコンソールに出る
                        $.ajax('postal_search.php', 
                            {
                            type: 'post',
                            data: {
                                postal_code: $('#postal_code1').val() + $('#postal_code2').val(),
                            },
                            scriptCharset: 'utf-8',
                            dataType: 'json'//jsonで受け取り
                            }
                        )
                        .done(function(data){
                            // console.log('ok');
                            // console.log(data);
                            try
                            {
                                $("#error").text('');
                                // var array = JSON.parse(data);
                                // document.write(data.prefecture);
                                $("#prefecture_id").val(data.prefecture_id);
                                $("#prefecture").val(data.prefecture);
                                $("#address1").val(data.address1);
                                $("#address2").val(data.address2);
                            }
                            catch(e)
                            {
                                console.error(e);
                            }
                        })
                        //失敗時はエラーメッセージ表示とフォームの初期化
                        .fail(function(jqXHR, textStatus, errorThrown){
                            $("#XMLHttpRequest").html("XMLHttpRequest : " + jqXHR.status);
                            $("#textStatus").html("textStatus : " + textStatus);
                            $("#errorThrown").html("errorThrown : " + errorThrown);
                            $("#error").text('見つかりません。');
                            $("#pref").val('');
                            $("#address1").val('');
                            $("#address2").val('');
                        })
                    });
                });
                </script>
			<div>
                メールアドレス<br>
                <?php if(!empty($_SESSION['post']['contact']['email'])):?>
                <label><input type="text" name="email" value="<?= $_SESSION['post']['contact']['email'];?>" >
                <?php else:?>
                <label><input type="text" name="email" value="" >
                <?php endif;?>
			</div>
			<div>
                電話番号<br>
                <?php if(!empty($_SESSION['post']['contact']['phone_number'])):?>
                <label><input type="text" name="phone_number" value="<?= $_SESSION['post']['contact']['phone_number']?>" >
                <?php else:?>
                <label><input type="text" name="phone_number" value="" >
                <?php endif;?>
            </div>
			<div>
                当サイトを知ったきっかけ<br>
                <?php foreach($contact_triggeres as $contact_trigger):?>
                <label><input type="radio" name="contact_trigger_id" value="<?= $contact_trigger['id'];?>"
                <?php 
                if(!empty($_SESSION['post']['contact']['contact_trigger_id']))
                {
                    if($_SESSION['post']['contact']['contact_trigger_id'] === $contact_trigger['id'])
                    {
                        print 'checked';
                    }
                }
                ?>>
                <?=$contact_trigger['contact_trigger'];?></label>
                <?php endforeach;?>
			</div>
			<div>
				<label for="kind">お問い合わせの種類</label><br>
				<select id="kind" name="contact_category_id">
                    <?php foreach($contact_categories as $contact_category):?>
                        <option value="<?= $contact_category['id']?>"
                        <?php if(!empty($_SESSION['post']['contact']['contact_category_id']))
                        {
                            if($_SESSION['post']['contact']['contact_category_id'] === $contact_category['id'])
                            {
                                print 'selected';
                            }
                        }
                        ?>
                        ><?= $contact_category['contact_category'];?></option>
                    <?php endforeach;?>
				</select>
			</div>
			<div>
                <label>お問い合わせの具体的な内容<br>
                <?php if(!empty($_SESSION['post']['contact']['contact_content'])):?>
                <textarea name="contact_content"><?= $_SESSION['post']['contact']['contact_content']?></textarea></label>
                <?php else:?>
                <textarea name="contact_content"></textarea></label>
                <?php endif;?>
			</div>
			<div>
                <input type="hidden" name="token" value="<?= Safety::getToken();?>">
                <input type="submit" name="submit" value="送信">
			</div>
		</form>
	</main>
	<footer class="footer">
		<p>&copy;Copyright KUJIRA Cafe. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>