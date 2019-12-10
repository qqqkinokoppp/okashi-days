<?php 
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Address.php');

// セッションの開始
Session::sessionStart();
// var_dump($_SESSION['post']['add_member']);

//前回入力データがあればフォーム初期値用の変数に格納
if(isset($_SESSION['post']['add_member']))
{
    if(isset($_SESSION['post']['add_member']['user_name']))
    {
        $user_name = $_SESSION['post']['add_member']['user_name'];
    }
    if(isset($_SESSION['post']['add_member']['last_name']))
    {
        $last_name = $_SESSION['post']['add_member']['last_name'];
    }
    if(isset($_SESSION['post']['add_member']['first_name']))
    {
        $first_name = $_SESSION['post']['add_member']['first_name'];
    }
    if(isset($_SESSION['post']['add_member']['last_name_kana']))
    {
        $last_name_kana = $_SESSION['post']['add_member']['last_name_kana'];
    }
    if(isset($_SESSION['post']['add_member']['first_name_kana']))
    {
        $first_name_kana = $_SESSION['post']['add_member']['first_name_kana'];
    }
    if(isset($_SESSION['post']['add_member']['birthday']))
    {
        $birthday = $_SESSION['post']['add_member']['birthday'];
    }
    if(isset($_SESSION['post']['add_member']['gender']))
    {
        $gender = $_SESSION['post']['add_member']['gender'];
    }
    if(isset($_SESSION['post']['add_member']['postal_code1']))
    {
        $postal_code1 = $_SESSION['post']['add_member']['postal_code1'];
    }
    if(isset($_SESSION['post']['add_member']['postal_code2']))
    {
        $postal_code2 = $_SESSION['post']['add_member']['postal_code2'];
    }
    if(isset($_SESSION['post']['add_member']['prefecture']))
    {
        $prefecture = $_SESSION['post']['add_member']['prefecture'];
    }
    if(isset($_SESSION['post']['add_member']['prefecture_id']))
    {
        $prefecture_id = $_SESSION['post']['add_member']['prefecture_id'];
    }
    if(isset($_SESSION['post']['add_member']['address1']))
    {
        $address1 = $_SESSION['post']['add_member']['address1'];
    }
    if(isset($_SESSION['post']['add_member']['address2']))
    {
        $address2 = $_SESSION['post']['add_member']['address2'];
    }
    if(isset($_SESSION['post']['add_member']['phone_number']))
    {
        $phone_number = $_SESSION['post']['add_member']['phone_number'];
    }
    if(isset($_SESSION['post']['add_member']['email']))
    {
        $email = $_SESSION['post']['add_member']['email'];
    }
}

?>
<!-- 都道府県取得のためのDB接続 -->
<?php
$db = new Address();
$prefecture_lists = $db ->getPrefAll();
// var_dump($_SESSION['post']['add_member']);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>新規会員登録 | okashi days.</title>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../../index.php"><img src="../../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<nav class="nav">
			<ul>
				<li><a href="../../">ホーム</a></li>
                <li><a href="../../order/cart/">カート</a></li>
                <li><a href="../../item/category/">商品カテゴリ一覧</a></li>
				<li><a href="../../item/list.php">商品一覧</a></li>
				<?php if(!isset($user)):?>
				<li><a href="./">新規会員登録</a></li>
				<li><a href="../login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>

    <main>
        <?php if(!empty($_SESSION['error']['add_member'])):?>
        <p class="error">
            <?= $_SESSION['error']['add_member'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
            <table class="list">
                <tr>
                    <th>ユーザー名</th>
                    <td class="align-left">
                        <?php if(isset($user_name)):?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="<?= $user_name?>" required>
                        <?php else:?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="" required>
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>会員氏名（姓）</th>
                    <td class="align-left">
                    <?php if(isset($last_name)):?>
                    <input type="text" name="last_name" id="last_name" class="last_name" value="<?= $last_name?>">
                    <?php else:?>
                    <input type="text" name="last_name" id="last_name" class="last_name" value="">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>会員氏名（名）</th>
                    <td class="align-left">
                    <?php if(isset($first_name)):?>
                    <input type="text" name="first_name" id="first_name" class="first_name" value="<?= $first_name?>">
                    <?php else:?>
                    <input type="text" name="first_name" id="first_name" class="first_name" value="">
                    <?php endif;?>
                    </td>
                </tr>
                

                <tr>
                    <th>会員氏名（姓フリガナ）</th>
                    <td class="align-left">
                    <?php if(isset($last_name_kana)):?>
                    <input type="text" name="last_name_kana" id="last_name_kana" class="last_name_kana" value="<?= $last_name_kana?>">
                    <?php else:?>
                    <input type="text" name="last_name_kana" id="last_name_kana" class="last_name_kana" value="">
                    <?php endif;?>
                    </td>
                </tr>

                
                <tr>
                    <th>会員氏名（名フリガナ）</th>
                    <td class="align-left">
                    <?php if(isset($first_name_kana)):?>
                    <input type="text" name="first_name_kana" id="first_name_kana" class="first_name_kana" value="<?= $first_name_kana?>">
                    <?php else:?>
                    <input type="text" name="first_name_kana" id="first_name_kana" class="first_name_kana" value="">
                    <?php endif;?>
                    </td>
                </tr>

                
                <tr>
                    <th>生年月日</th>
                    <td class="align-left">
                    <?php if(isset($birthday)):?>
                    <input type="date" name="birthday" id="birthday" class="birthday" value="<?= $birthday?>">
                    <?php else:?>
                    <input type="date" name="birthday" id="birthday" class="birthday" value="">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>性別</th>
                    <td class="align-left">
                    <input type="radio" name="gender"  class="gender" value="0" <?php if(isset($gender)){if($gender === '0'){ print 'checked';}}?>>男性
                    <input type="radio" name="gender"  class="gender" value="1" <?php if(isset($gender)){if($gender === '1'){ print 'checked';}}?>>女性
                    <input type="radio" name="gender"  class="gender" value="2" <?php if(isset($gender)){if($gender === '2'){ print 'checked';}}?>>回答しない
                    </td>
                </tr>

                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?php if(isset($postal_code1)&&isset($postal_code2)):?>
                    <input type="text" name="postal_code1" id="postal_code1" class="postal_code1" value="<?= $postal_code1?>" style="width:50px;">-
                    <input type="text" name="postal_code2" id="postal_code2" class="postal_code2" value="<?= $postal_code2?>" style="width:50px;">
                    <?php else:?>
                    <input type="text" name="postal_code1" id="postal_code1" class="postal_code1" value="" style="width:50px;">-
                    <input type="text" name="postal_code2" id="postal_code2" class="postal_code2" value="" style="width:50px;">
                    <?php endif;?>
                    <input type="button" value="住所検索" id="search"><div id="error"></div>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <select name="prefecture_id" id="prefecture_id">
                    <option value=""></option>
                    <?php foreach($prefecture_lists as $prefecture_list):?>
                    
                    <option value="<?= $prefecture_list['id']?>" 
                    <?php if(isset($prefecture_id)){if($prefecture_id === $prefecture_list['id']){ print 'selected';}}?>>
                    <?= $prefecture_list['prefecture']?>
                    </option>
                    
                    <?php endforeach;?>
                    </select>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村）</th>
                    <td class="align-left">
                    <?php if(isset($birthday)):?>
                    <input type="text" name="address1" id="address1" class="address1" value="<?= $address1?>">
                    <?php else:?>
                    <input type="text" name="address1" id="address1" class="address1" value="">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地、建物名、以降の住所）</th>
                    <td class="align-left">
                    <?php if(isset($birthday)):?>
                    <input type="text" name="address2" id="address2" class="address2" value="<?= $address2?>">
                    <?php else:?>
                    <input type="text" name="address2" id="address2" class="address2" value="">
                    <?php endif;?>
                    </td>
                </tr>
                <!-- hiddenで都道府県名もpostする -->
                <?php if(isset($prefecture)):?>
                <input type="hidden" name="prefecture" id="prefecture" class="prefecture" value="<?= $prefecture?>">
                <?php else:?>
                <input type="hidden" name="prefecture" id="prefecture" class="prefecture" value="">
                <?php endif;?>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?php if(isset($phone_number)):?>
                    <input type="text" name="phone_number" id="pohne_number" class="phone_number" value="<?= $phone_number?>">
                    <?php else:?>
                    <input type="text" name="phone_number" id="phone_number" class="phone_number" value="">
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

            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken()?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>
    <p>&copy;Copyright Okashi days. All rights reserved.</p>
    </footer>
</div>
    <!-- 住所検索システム -->
    <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
    $(function() {
        $('#search').click(function() {
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
            .done(function(data) {
                // console.log('ok');
                // console.log(data);
                try {
                    $("#error").text('');
                    // var array = JSON.parse(data);
                    // document.write(data.prefecture);
                    $("#prefecture_id").val(data.prefecture_id);
                    $("#prefecture").val(data.prefecture);
                    $("#address1").val(data.address1);
                    $("#address2").val(data.address2);
                } catch(e) {
                    console.error(e);
                }
            })
            //失敗時はエラーメッセージ表示とフォームの初期化
            .fail(function(jqXHR, textStatus, errorThrown) {
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

</body>
</html>